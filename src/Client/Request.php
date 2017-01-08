<?php
namespace CjsJsonrpc\Client;
use CjsJsonrpc\Core\RequestBuilder;
use CjsJsonrpc\Util\ObjectId;
use CjsJsonrpc\Util\Errorable;
use CjsJsonrpc\Util\Curl;

class Request extends Errorable {

    protected $_module = null;
    protected $_method;
    protected $_config;

    /**
     * Request constructor.
     * @param $config = [
     *                  'url'  => 'http://localhost/rpc.php',
     *                  'headers'=>[],
     *                  'option'=>[],  //curl用的option
     *                  ]
     */
    public function __construct($config)
    {
        $this->_config = $config;
    }

    public static function create($config)
    {
        return new static($config);
    }


    public function module($module)
    {
        $this->_module = $module;
        return $this;
    }

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
        //echo $postJson . PHP_EOL;
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