<?php
require_once __DIR__ . '/common.php';

//拼接单个jsonrpc请求格式
$obj = CjsJsonrpc\Core\RequestBuilder::create();
$obj->setMethod("User\\Profile.getinfo")->setParams(['userid'=>134, 'status'=>1]);
$obj->setId(\CjsJsonrpc\Util\ObjectId::create()->getId());

echo $obj->toString();
echo PHP_EOL;

var_export($obj->toArray());
echo PHP_EOL;


