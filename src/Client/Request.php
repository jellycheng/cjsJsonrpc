<?php
namespace CjsJsonrpc\Client;
use CjsJsonrpc\Core\Collection;
use CjsJsonrpc\Core\RequestBuilder;
use CjsJsonrpc\Core\Error;
use CjsJsonrpc\Core\Status;
use CjsJsonrpc\Util\ObjectId;
use CjsJsonrpc\Util\Errorable;
use CjsJsonrpc\Util\Curl;
use CjsJsonrpc\Util\Log;


class Request extends Errorable {

    protected $_module = null;
    protected $_method;
    protected $_config;
    protected $_collection;
    protected $_debug = false;
    protected $_log;

    /**
     *
     * @param $config = [
     *                  'url'  => 'http://localhost/rpc.php',
     *                  'headers'=>[],
     *                  'option'=>[],  //curl用的option
     *                  'debug'=>false,
     *                  ]
     */
    public function __construct(array $config)
    {
        $this->_config = $config;
        $this->_debug = \CjsJsonrpc\array_get($config, 'debug', false);
        $this->_collection = Collection::create();
        $this->_log = \CjsJsonrpc\array_get($config, 'log', Log::create());
    }

    public static function create($config)
    {
        return new static($config);
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function module($module)
    {
        $this->_module = $module;
        return $this;
    }

    /**
     * 单个请求
     * @param $method
     * @param $arguments
     * @return string
     */
    public function __call($method, $arguments)
    {
        $this->_method = $method;
        if($this->_module) {
            $method = $this->_module . '.' . $this->_method;
        } else {
            $method = $this->_method;
        }
        $obj = RequestBuilder::create();
        $obj->setMethod($method)->setParams($arguments);
        $obj->setId(ObjectId::create()->getId());
        $postJson = $obj->toString();
        //发起curl请求
        $content = $this->requestPost($postJson);
        return $content;

    }

    /**
     * 批量聚合请求
     * @param array $param
     * @return array|bool|int|mixed|\stdClass|string|static
     */
    public function batchCall($param)
    {
        if(!is_array($param)) {
            return [];
        }
        foreach($param as $k=>$v) {
            $_method = isset($v[0])?$v[0]:'';
            $obj = RequestBuilder::create();
            $obj->setMethod($_method);
            if(isset($v[1])) {
                $obj->setParams($v[1]);
            }
            $obj->setId(ObjectId::create()->getId());
            $this->_collection->set($k, $obj->toArray());
        }
        return $this->requestPost(null);
    }


    protected function requestPost($postJson = null) {
        $this->clearErr();
        if($this->_collection->count() > 1) {
            //批量聚合
            $postJsonData = [];
            $allKey = [];
            $batchAll = $this->_collection->all();
            foreach($batchAll as $_batk=>$_batv) {
                $postJsonData[] = $_batv;
                $allKey[] = $_batk;
            }
            $postJson = \CjsJsonrpc\json_encode($postJsonData);
            $isBat = true;
        } else {
            //单个
            $isBat = false;
            $allKey = [];
        }
        if($this->_debug) {
            $this->_log->debug("request: " . $postJson . PHP_EOL);
        }

        $url = \CjsJsonrpc\array_get($this->_config, 'url', '');
        $curlObj = Curl::create($url);
        $option = \CjsJsonrpc\array_get($this->_config, 'option', []);
        if(is_array($option) && $option) {
            $curlObj->setOption($option);
        }
        $header = \CjsJsonrpc\array_get($this->_config, 'headers', []);
        if(is_array($header) && $header) {
            $curlObj->setHeaders($header);
        }
        $content = $curlObj->post(null, $postJson)->getResponse();
        //解析响应jsonrpc
        if($this->_debug) {
            $this->_log->debug("response: " . $content . PHP_EOL);
        }

        if(false === $content || $curlObj->errno()) {
            $ret = false;
            $this->setErr($curlObj->errno(), $curlObj->errstr());
        } else if(true === $content) {
            $ret = true;
        } else {
            //解析rpc
            $ret = $this->decodeResponse($content, $isBat, $allKey);
        }

        return $ret;
    }

    protected function decodeResponse($str, $isBat=false, $allKey=[])
    {

        if(is_array($str)) {
            $data = $str;
        } else {
            $data = @\json_decode($str, true);
            if(!is_array($data)) {
                $this->setErr(Status::PARSE_ERROR, Status::desc(Status::PARSE_ERROR));
            }
        }
        if(!$isBat) {
            $ret = false;
            if(array_key_exists('error', $data)) {
                $this->setErr(\CjsJsonrpc\array_get($data['error'],'code'),\CjsJsonrpc\array_get($data['error'],'message') );
            } else if(array_key_exists('result', $data)) {
                $ret = $data['result'];
            } else {
                $this->setErr(Status::JSON_FORMART_ERROR, Status::desc(Status::JSON_FORMART_ERROR));
            }
        } else {
            $ret = [];
            foreach((array)$data as $_k=>$v) {
                $tmpK = $allKey[$_k];
                if(array_key_exists('error', $v)) {
                    $errorObj = Error::create()->setCode(\CjsJsonrpc\array_get($v['error'],'code'))->setMessage(\CjsJsonrpc\array_get($v['error'],'message'));
                    if(isset($v['data'])) {
                        $errorObj->setData($v['data']);
                    }
                    $ret[$tmpK] = $errorObj;
                } else if(array_key_exists('result', $v)) {
                    $ret[$tmpK] = $v['result'];
                } else {
                    $errorObj = Error::create()->setCode(Status::JSON_FORMART_ERROR)->setMessage(Status::desc(Status::JSON_FORMART_ERROR));
                    $ret[$tmpK] = $errorObj;
                }

            }

        }


        return $ret;
    }

}