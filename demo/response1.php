<?php
require_once __DIR__ . '/common.php';
use CjsJsonrpc\Core\ResponseBuilder;

echo ResponseBuilder::create()->response();
echo PHP_EOL;
echo ResponseBuilder::create()->setResult(['code'=>0, 'message'=>'ok', 'data'=>['userid'=>123, 'name'=>'jelly']])->response();
echo PHP_EOL;


$data = ResponseBuilder::create()->setResult(['code'=>0, 'message'=>'ok', 'data'=>['userid'=>123, 'name'=>'jelly']])->toArray();
var_export($data);
echo PHP_EOL;

$error = ResponseBuilder::error(['code'=>1000, 'message'=>'错误信息', 'data'=>"data content"]);
echo ResponseBuilder::create()->setIsError(true)->setError($error)->response();
echo PHP_EOL;

