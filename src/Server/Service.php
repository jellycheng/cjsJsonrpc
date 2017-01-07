<?php
namespace CjsJsonrpc\Server;
use CjsJsonrpc\Core\ResponseBuilder as Response;
use CjsJsonrpc\Core\Status;

class Service {

    private $lookup = null;

    public static function create($lookup) {
        $service = new static;

        $service->lookup = $lookup;
        return $service;

    }


    public function send($msg) {
        $reply = null;
        $req = $this->decodeRequest($msg);
        do {
            if (false === $req) {
                $reply = Response::error(Status::INVALID_REQUEST);
                break;
            }

            $rc = preg_match(
                '#(?:(?P<module>\w+)\.)?(?P<method>.+)#',
                $req->getMethod(),
                $match
            );

            if ($rc <= 0) {
                $reply = Response::error(Status::INVALID_REQUEST);
                if (property_exists($req, 'id')) {

                }
                break;
            }

            $method = null;

            if (isset($match['method']) && !empty($match['method'])) {
                $method = $match['method'];
            } else {
                $reply = Response::error(Status::INVALID_REQUEST);
                if (property_exists($req, 'id')) {

                }
                break;
            }

            $module = null;

            if (isset($match['module']) && !empty($match['module'])) {
                $module = $match['module'];
            }

            $params = (array)$req->params;
            $callable = $this->lookupInternal($module, $method, $params);
            if (is_callable($callable)) {
                try {
                    $result = call_user_func_array($callable, $params);
                    $reply = Response::success($result);
                } catch (\Exception $e) {
                    $reply = Response::error(array(
                                                'code'    => Status::INTERNAL_ERROR,
                                                'message' => $e->getMessage()
                                            ));
                }
            } elseif ($callable instanceof Response) {
                $reply = Response::success($callable->reply);
            } else {
                $reply = Response::error(Status::METHOD_NOT_EXISTS);
            }

            if (property_exists($req, 'id')) {

            }
        } while (0);

        return 'todo';


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

}