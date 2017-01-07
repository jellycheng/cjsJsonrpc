<?php
require_once __DIR__ . '/common.php';
use CjsJsonrpc\Server\Service;


Service::create(function ($module, $method, $params, $id) {
    $ret = null;
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
    if (class_exists($class)) {
        $callable = array(new $class, $method);
        if (is_callable($callable)) {
            $ret = $callable;
        }
    }

    return $ret;
})->send(file_get_contents('php://input'));