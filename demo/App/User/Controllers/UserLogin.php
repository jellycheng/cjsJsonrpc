<?php
namespace App\User\Controllers;

class UserLogin {

    public function createLoginLog($a, $b, $c) {
        $logFile = dirname(dirname(__DIR__)) . '/rpc.log';
        $c = is_array($c)?var_export($c, true):$c;
        error_log(sprintf('a: %s , b: %s c:%s', $a, $b, $c . PHP_EOL), 3, $logFile);
        return ['log success'];

    }


    public function welcome($msg) {
        return "hello welcome: " . $msg;
    }

}