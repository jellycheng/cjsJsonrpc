<?php
require __DIR__ . '/common.php';

$id = new \CjsJsonrpc\Util\ObjectId();
echo $id . PHP_EOL;

echo $id->getId() . PHP_EOL;

