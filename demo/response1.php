<?php
require_once __DIR__ . '/common.php';
use CjsJsonrpc\Core\ResponseBuilder;

echo ResponseBuilder::create()->response();
echo PHP_EOL;


$error = ResponseBuilder::error(['code'=>1000, 'message'=>'错误信息', 'data'=>"data content"]);
echo ResponseBuilder::create()->setIsError(true)->setError($error)->response();
echo PHP_EOL;

