<?php

$batchStr = '[
    {"jsonrpc":"2.0","method":"","params":"","id":813719972},
    {"jsonrpc":"2.0","method":"","params":"","id":813719973}
]';

var_export(\json_decode($batchStr, true));


$batchAry = array (
    array (
            'jsonrpc' => '2.0',
            'method' => '',
            'params' => '',
            'id' => 813719972,
        ),
    array (
            'jsonrpc' => '2.0',
            'method' => '',
            'params' => '',
            'id' => 813719973,
        ),
);

echo \json_encode($batchAry);
echo PHP_EOL;
