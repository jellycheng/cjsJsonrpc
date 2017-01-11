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
$content = \CjsJsonrpc\batchCall("news", [
                                        'log'=>["User\\UserLogin.createLoginLog", $param],
                                        ["User\\UserLogin.noFun", [123]],
                                        [],
                                        ['abcFun']
                                        ]
                                );

\CjsJsonrpc\debug($content);

\CjsJsonrpc\debug($content['log']);

if($content[0] instanceof CjsJsonrpc\Core\Error) {
    $errorData = $content[0]->toArray();
    echo 'code  : ', $errorData['code'], "\n";
    echo 'message : ', $errorData['message'], "\n";
}
var_export($content);




