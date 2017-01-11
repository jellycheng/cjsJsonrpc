<?php
namespace CjsJsonrpc\Client;

class Service {

    private static $conf   = [];
    protected $request = null;
    static private $shared  = [];

    public static function importConf($conf)
    {
        self::$conf = array_merge(self::$conf, $conf);
        return true;
    }

    public function __construct($key)
    {
        if (isset(self::$conf[$key]))
        {
            $this->request = new Request(self::$conf[$key]['conf']);
        } else {
            throw new \Exception("缺少RPC配置文件");
        }

    }

    public static function get($key, $share=false)
    {
        if ($share && isset(self::$shared[$key])) {
            return self::$shared[$key];
        }
        $service = new static($key);
        if ($share) {
            self::$shared[$key] = $service;
        }
        return $service;
    }


    public function module($module)
    {
        $this->request->module($module);
        return $this->request;
    }

    public function getRequest() {
        return $this->request;
    }

    /**
     * 当个请求
     * @param string $str = user配置key::user\\profile.getinfo
     * @param mixed $param 参数
     * @param null $err
     */
    public static function call($str, $param, &$err=null)
    {
        $ret = false;
        $rc = preg_match('/((?:[\w|\-\_])+)::(.+)/', $str, $matches);
        if ($rc) {
            $key     = $matches[1];
            $methodTmp = explode('.', $matches[2], 2);//Jifen\\UserJifenLog.logList
            $module = $methodTmp[0];
            $method = $methodTmp[1];
            $clientService = self::get($key);
            $request = $clientService->module($module);
            $ret = call_user_func_array(array($request, $method), $param);
            if ($request->errno()) {
                $err = $request->errstr();
            }

        }

        return $ret;

    }

    /**
     * 聚合批量请求
     * @param string $rpcCfgKey
     * @param array $param
     * @param null $err
     */
    public static function batchCall($rpcCfgKey, $param)
    {
        $ret = null;
        $clientService = self::get($rpcCfgKey);

        $ret = \CjsJsonrpc\with($clientService->getRequest())->batchCall($param);

        return $ret;
    }

    /**
     * 并发请求
     * @param array $param
     * @param null $err
     */
    public static function concurrentRequest($param, &$err=null)
    {
        $ret = null;



        return $ret;
    }


}