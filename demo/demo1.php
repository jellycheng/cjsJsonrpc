<?php
require_once __DIR__ . '/common.php';

$obj = new CjsJsonrpc\Core\RequestBuilder();

echo $obj->toString();
echo PHP_EOL;

var_export($obj->toArray());
echo PHP_EOL;


