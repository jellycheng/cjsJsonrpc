<?php
require_once __DIR__ . '/common.php';
use CjsJsonrpc\Server\Service;

$logFile = __DIR__ . '/rpc.log';
error_log(file_get_contents('php://input') . PHP_EOL, 3, $logFile);

Service::create(function($module, $method, $params, $id) use($logFile) {
    $ret = null;
    error_log(sprintf('module: %s , method: %s ', $module, $method . PHP_EOL), 3, $logFile);

    $pieces = explode('\\', $module, 2);
    if (!$pieces || count($pieces) !== 2) {
        return $ret;
    }
    $pieces[0] = ucfirst(strtolower($pieces[0]));
    $class = sprintf('App\\%s\\Controllers\\%s', $pieces[0], $pieces[1]);
    if($pieces[0]=='User') {
        if(defined('PHPUNIT_TEST_ENV_OVERRIDE') && PHPUNIT_TEST_ENV_OVERRIDE === 'test' ) {
            //是单元测试进来
        } else {//token 合法性判断

        }
    }
    error_log(sprintf('class: %s , method: %s ', $class, $method . PHP_EOL), 3, $logFile);
    if (class_exists($class)) {
        $callable = array(new $class, $method);
        if (is_callable($callable)) {
            $ret = $callable;
        }
    }
    return $ret;
})->send(file_get_contents('php://input'));