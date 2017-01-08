<?php
namespace CjsJsonrpc\Client;

class Service {

    private static $conf   = array();

    public static function importConf($conf)
    {
        self::$conf = array_merge(self::$conf, $conf);
        return true;
    }

    public function __construct($key)
    {
        if (isset(self::$conf[$key])) {

        }

    }

    public static function get($key) {
        $client = new static($key);

        return $client;
    }


    public function module($module)
    {


    }



}