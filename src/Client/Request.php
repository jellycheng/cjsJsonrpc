<?php
namespace CjsJsonrpc\Client;
use CjsJsonrpc\Core\Collection;
use CjsJsonrpc\Core\RequestBuilder;
use CjsJsonrpc\Util\ObjectId;
use CjsJsonrpc\Util\Errorable;
use CjsJsonrpc\Util\Curl;

class Request extends Errorable {

    protected $_module = null;
    protected $_method;
    protected $_config;
    protected $_collection;

    /**
     *
     * @param $config = [
     *                  'url'  => 'http://localhost/rpc.php',
     *                  'headers'=>[],
     *                  'option'=>[],  //curl用的option
     *                  ]
     */
    public function __construct($config)
    {
        $this->_config = $config;
        $this->_collection = Collection::create();
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
     * @param $param
     */
    public function batchCall($param)
    {

    }


    protected function requestPost($postJson = null) {
        if($this->_collection->count() > 1) {
            //批量聚合
            $postJson = [];

        } else {
            //单个


        }
        echo $postJson . PHP_EOL;

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
        return $content;
    }



}