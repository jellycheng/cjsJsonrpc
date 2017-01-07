<?php
namespace CjsJsonrpc\Core;

class RequestBuilder {

    protected $requestRpcObj;

    public function __construct()
    {
        $this->requestRpcObj = new \stdClass();
        $this->requestRpcObj->id = null;
        $this->requestRpcObj->jsonrpc = '2.0';
        $this->requestRpcObj->method = '';
        //$this->requestRpcObj->params = '';
    }

    /**
     * @param string $jsonrpc
     * @return RequestBuilder
     */
    public function setJsonrpc($jsonrpc)
    {
        $this->requestRpcObj->jsonrpc = $jsonrpc;
        return $this;
    }

    /**
     * @param string $method
     * @return RequestBuilder
     */
    public function setMethod($method)
    {
        $this->requestRpcObj->method = $method;
        return $this;
    }

    /**
     * @param string $params
     * @return RequestBuilder
     */
    public function setParams($params)
    {
        $this->requestRpcObj->params = $params;
        return $this;
    }

    /**
     * @param int $id
     * @return RequestBuilder
     */
    public function setId($id)
    {
        $this->requestRpcObj->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getJsonrpc()
    {
        return $this->requestRpcObj->jsonrpc;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->requestRpcObj->method;
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return $this->requestRpcObj->params;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->requestRpcObj->id;
    }

    public static function create()
    {
        return new static();
    }

    public function getRequestRpcObj() {
        return $this->requestRpcObj;
    }

    public function toString() {
        $options = 0;
        if (defined('JSON_UNESCAPED_SLASHES')) {
            $options |= JSON_UNESCAPED_SLASHES;
        }
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $options |= JSON_UNESCAPED_UNICODE;
        }
        $jsonRpcData = array(
                        'jsonrpc' => $this->requestRpcObj->jsonrpc,
                        'method' => $this->requestRpcObj->method,
                        //'params' => $this->requestRpcObj->params,
                        'id' => $this->requestRpcObj->id,
                    );
        if(property_exists($this->requestRpcObj, 'params')) {
            $jsonRpcData['params'] = $this->requestRpcObj->params;
        }
        return json_encode($jsonRpcData, $options);
    }

    public function toArray() {
        $jsonRpcData = array(
            'jsonrpc' => $this->requestRpcObj->jsonrpc,
            'method' => $this->requestRpcObj->method,
            //'params' => $this->requestRpcObj->params,
            'id' => $this->requestRpcObj->id,
        );
        if(property_exists($this->requestRpcObj, 'params')) {
            $jsonRpcData['params'] = $this->requestRpcObj->params;
        }
        return $jsonRpcData;
    }


}