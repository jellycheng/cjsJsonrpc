<?php
namespace CjsJsonrpc\Server;
use CjsJsonrpc\Core\ResponseBuilder as Response;
use CjsJsonrpc\Core\Status;
use CjsJsonrpc\Util\Errorable;
use CjsJsonrpc\Core\Error;
use CjsJsonrpc\Core\Success;

class Service extends Errorable {

    private $lookup = null;

    public static function create($lookup) {
        $service = new static;

        $service->lookup = $lookup;
        return $service;

    }

    protected function dealOne($data){
        $responseObj = Response::create();
        $requestId = isset($data['id'])?$data['id']:null;
        do {
            $rc = preg_match(
                '#(?:(?P<module>\w+)\.)?(?P<method>.+)#',
                $data['method'],
                $match
            );
            if ($rc <= 0) {
                $errorObj = Response::error(Status::INVALID_REQUEST);
                $responseObj->setIsError(true)->setError($errorObj);
                break;
            }
            $method = null;
            if (isset($match['method']) && !empty($match['method'])) {
                $method = $match['method'];
            } else {
                $errorObj = Response::error(Status::INVALID_REQUEST);
                $responseObj->setIsError(true)->setError($errorObj);
                break;
            }
            $module = null;
            if (isset($match['module']) && !empty($match['module'])) {
                $module = $match['module'];
            }
            $params = (array)$data['params'];
            $callable = $this->lookupInternal($module, $method, $params, $requestId);
            if (is_callable($callable)) {
                try {
                    $result = call_user_func_array($callable, $params);
                    $responseObj->setResult($result);
                } catch (\Exception $e) {
                    $errorObj = Response::error(array(
                                                    'code'=> Status::INTERNAL_ERROR,
                                                    'message' => $e->getMessage()
                                                ));
                    $responseObj->setIsError(true)->setError($errorObj);
                }
            } elseif ($callable instanceof Response) {
                $responseObj->setResult($callable->getResult());
            } else {
                $errorObj = Response::error(Status::METHOD_NOT_EXISTS);
                $responseObj->setIsError(true)->setError($errorObj);
            }

        } while (0);
        if (isset($data['id'])) {
            $responseObj->setId($data['id']);
        }
        return $responseObj;
    }


    public function send($msg, $isExit = true) {
       // $msg = '{"jsonrpc":"2.0","method":"User\\\\UserLogin.createLoginLog","id":"58739d15177002b600a05a3e","params":["1234",1,{"op":"add","content":"新增角色"}]}';
        $this->clearErr();
        $reply = null;
        $req = $this->decodeRequest($msg);
        //var_export($req);
        if (!$req) {
            $responseObj = Response::create();
            $errorObj = Response::error(Status::INVALID_REQUEST);
            $reply = $responseObj->setIsError(true)->setError($errorObj)->toArray();
        } else {
            if (isset($req['method'])) {
                //单条请求
                $responeObj = $this->dealOne($req);
                $reply = $responeObj->toArray();
            } else {
                //批量请求
                $reply = [];
                foreach($req as $_k=>$_v) {
                    $responeObj = $this->dealOne($_v);
                    $reply[] = $responeObj->toArray();
                }
            }
        }

        $content = $this->jsonEncode($reply);
        if($isExit) {
          echo $content;exit;
        }
        return $content;
    }

    protected function lookupInternal($module, $method, $params, $id = null)
    {
        $ret = false;
        if ($this->lookup) {
            $ret = call_user_func($this->lookup, $module, $method, $params, $id);
        }
        return $ret;
    }

    protected function decodeRequest($str) {
        $data = is_array($str) ? $str : json_decode($str, true);
        return $data;
    }

    protected function jsonEncode($data)
    {
        $options = 0;
        if (defined('JSON_UNESCAPED_SLASHES')) {
            $options |= JSON_UNESCAPED_SLASHES;
        }
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $options |= JSON_UNESCAPED_UNICODE;
        }
        return json_encode($data, $options);
    }

}