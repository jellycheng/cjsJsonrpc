<?php
require __DIR__ . '/common.php';

use CjsJsonrpc\Client\Service as ClientService;
use CjsJsonrpc\Server\Service as ServerService;

ClientService::importConf(
    array(
        'user' => array(
            'type' => 'local', //远程rpc 还是调用本地仓库代码rpc
            'conf' => array(
                'service' => ServerService::create('local',
                                            function ($module, $method, $params, $id) {
                                                return 'todo';
                                            })
            )
        ),
        'pay'=>array(
            'type' => 'http',
            'protocol' => 'jsonrpc',
            'conf' => array(
                'url'  => 'http://domain.com/rpc.php'
            )
        ),
        'news'=>array(
            'type' => 'http',
            'protocol' => 'jsonrpc',
            'conf' => array(
                'url'  => 'http://localhost/rpc.php'
            )
        ),

    )
);


$userModule = ClientService::get('news')->module('User\\UserLogin');//模块
$rep = $userModule->createLoginLog($uid, $type, $ext);  //记录用户登录日志
if (!$userModule->errno()) {//没有发生错误
    echo 'rep : ';
    if (is_array($rep)) {
        $str = var_export($rep, true) . PHP_EOL;
    } else {
        $str = $rep . PHP_EOL;
    }
    echo isWin() ? mb_convert_encoding($str, 'gbk', 'utf-8') : $str;
} else {//rpc发生错误了
    echo 'errno  : ', $userModule->errno(), "\n";
    echo 'errstr : ', $userModule->errstr(), "\n";
}

