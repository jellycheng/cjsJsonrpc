<?php
namespace CjsJsonrpc;

use CjsJsonrpc\Client\Service;

/**
 * 设置配置
 * @param $conf
 */
function importConf($conf)
{
    Service::importConf($conf);
}

/**
 * 单次调用
 * @param $method
 * @param $params
 * @param null $err
 * @return mixed
 */
function rpcCall($method, $params, &$err = null)
{
    return Service::call($method, $params, $err);
}

/**
 * 一次请求批量调用多个api
 * @param $calls
 * @param null $err
 * @return mixed
 */
function batchCall($calls, &$err = null)
{
    return Service::batchCall($calls, $err);
}

/**
 * 并发调用 todo
 */


/**
 * 反射服务器api方法
 * @param $module
 * @param null $err
 * @return mixed
 */
function explore($module, &$err = null) {
    return Service::call($module . '.__explore', [], $err);
}



