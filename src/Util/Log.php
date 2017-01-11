<?php
namespace CjsJsonrpc\Util;

class Log {

    public static function create() {
        return new static();
    }

    public function debug($msg)
    {
        $logFile = dirname(dirname(__DIR__)) . '/demo/rpc_client.log';
        error_log($msg, 3, $logFile);

    }

}