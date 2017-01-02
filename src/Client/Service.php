<?php
namespace CjsJsonrpc\Client;

class Service {

    private static $conf   = array();

    public static function importConf($conf)
    {
        self::$conf = array_merge(self::$conf, $conf);
        return true;
    }


}