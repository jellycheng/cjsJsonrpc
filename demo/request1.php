<?php
require_once __DIR__ . '/common.php';

$obj = CjsJsonrpc\Core\RequestBuilder::create();
$obj->setMethod("User\\Profile.getinfo")->setParams(['userid'=>134, 'status'=>1]);
$obj->setId(\CjsJsonrpc\Util\ObjectId::create()->getId());

$json1 = $obj->toArray();

use CjsJsonrpc\Core\Collection;
$jsonrpcFormat = Collection::create();
$jsonrpcFormat['getUserInfo'] = $json1;

echo is_array($jsonrpcFormat['getUserInfo'])?var_export($jsonrpcFormat['getUserInfo'], true):$jsonrpcFormat['getUserInfo'];
echo PHP_EOL;

if($jsonrpcFormat->count() > 1) {
    echo "批量rpc" . PHP_EOL;

} else {
    echo "单个rpc请求" . PHP_EOL;
    foreach($jsonrpcFormat as $kone=>$vone) {
        echo json_encode($vone) . PHP_EOL;
    }
}

//---------------------------------------------------
$obj = CjsJsonrpc\Core\RequestBuilder::create();
$obj->setMethod("User\\Profile.editNickname")->setParams(['userid'=>123, 'nickname'=>'jelly']);
$obj->setId(\CjsJsonrpc\Util\ObjectId::create()->getId());
$json2 = $obj->toArray();
$jsonrpcFormat2 = Collection::create();
$jsonrpcFormat2['getUserInfo'] = $json1;
$jsonrpcFormat2['editnickname'] = $json2;

if($jsonrpcFormat2->count() > 1) {
    //
    echo "批量rpc" . PHP_EOL;
    echo json_encode($jsonrpcFormat2->all(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . PHP_EOL;
    $allKey = [];
    $rpcPL = [];
    foreach($jsonrpcFormat2 as $k=>$v) {
        $rpcPL[] = $v;
        $allKey[] = $k;
    }
    echo json_encode($rpcPL, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . PHP_EOL;
    echo var_export($allKey, true) . PHP_EOL;
} else {
    echo "单个rpc请求" . PHP_EOL;
}

