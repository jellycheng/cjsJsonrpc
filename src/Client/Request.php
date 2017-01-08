<?php
namespace CjsJsonrpc\Client;

class Request {

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
        //发起curl请求

    }





}