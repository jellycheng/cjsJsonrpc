<?php
namespace CjsJsonrpc;

use CjsJsonrpc\Client\Service;

/**
 * 设置配置
 * @param array $conf
 */
function importConf($conf)
{
    Service::importConf($conf);
}

/**
 * 单次调用
 * @param string $method
 * @param array $params
 * @param null|mixed $err
 * @return mixed
 */
function rpcCall($method, $params, &$err = null)
{
    return Service::call($method, $params, $err);
}

/**
 * 一次请求批量调用多个api
 * @param array $calls
 * @param null|mixed $err
 * @return mixed
 */
function batchCall($calls, &$err = null)
{
    return Service::batchCall($calls, $err);
}

/**
 * 并发调用
 * @param array $params
 * @param null|mixed $err
 */
function concurrentRequest($params, &$err=null)
{
    return Service::concurrentRequest($params, $err);
}

/**
 * 反射服务器api方法
 * @param string $module
 * @param null|mixed $err
 * @return mixed
 */
function explore($module, &$err = null) {
    return Service::call($module . '.__explore', [], $err);
}


/**
 * @param array $array
 * @param string $key
 * @param null $default
 * @return null|mixed
 */
function array_get($array, $key, $default = null)
{
    if (is_null($key)) return $array;
    if (isset($array[$key])) return $array[$key];
    $keyA = explode('.', $key);
    foreach ($keyA as $segment)
    {// a.b.c
        if ( ! is_array($array) || ! array_key_exists($segment, $array))
        {   //不存在的key则返回默认值
            return $default instanceof \Closure ? $default() : $default;
        }
        $array = $array[$segment];
    }
    return $array;
}



