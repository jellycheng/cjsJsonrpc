<?php
require_once __DIR__ . '/common.php';

use CjsJsonrpc\Core\Error;
$obj = Error::create();
$obj->getRpcError()->code = 1000;
$obj->getRpcError()->message = 'hello world';
var_export($obj->toArray());



$obj2 = Error::create();
$obj2->getRpcError()->code = 0;
$obj2->getRpcError()->message = 'param fail';
$obj2->getRpcError()->data = 'data content';
var_export($obj2->toArray());

$obj3 = Error::create();
$obj3->setCode(200)->setMessage("fail 2")->setData(['userid'=>123, 'usernmae'=>'jelly']);
var_export($obj3->toArray());

