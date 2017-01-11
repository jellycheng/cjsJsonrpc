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

$content = \CjsJsonrpc\explore("news::User\\UserLogin", $errorMsg);
if($errorMsg) {
    echo $errorMsg . PHP_EOL;
} else {
    \CjsJsonrpc\debug( $content);
}



