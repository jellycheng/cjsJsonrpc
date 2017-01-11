<?php
require __DIR__ . '/common.php';
use CjsJsonrpc\Client\Service as ClientService;

ClientService::importConf(
    array(
        'news'=>array(
            'type' => 'http',
            'protocol' => 'jsonrpc',
            'conf' => array(
                'url'  => 'http://localhost:9999/rpc.php',
                'debug'=>true,
            )
        ),

    )
);
$param = ["1234", 1, ['op'=>'add', 'content'=>'新增角色']];
$content = \CjsJsonrpc\rpcCall("news::User\\UserLogin.createLoginLog", $param, $errorMsg);
if($errorMsg) {
    \CjsJsonrpc\debug("Error: " . $errorMsg);
} else {
    \CjsJsonrpc\debug($content);
}


$param = ["1234"];
//方法不存在例子
$content = \CjsJsonrpc\rpcCall("news::User\\UserLogin.noFun", $param, $errorMsg);
if($errorMsg) {
    \CjsJsonrpc\debug("Error: " . $errorMsg);
} else {
    \CjsJsonrpc\debug($content);
}

