<?php
require_once __DIR__ . '/common.php';
use CjsJsonrpc\Core\ResponseBuilder;

echo ResponseBuilder::create()->response();
echo PHP_EOL;


