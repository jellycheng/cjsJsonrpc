<?php
namespace CjsJsonrpc\Core;

class RequestBuilder {

    protected $jsonrpc = '2.0';
    protected $method = '';
    protected $params = '';
    protected $id = 0;

    /**
     * @param string $jsonrpc
     * @return RequestBuilder
     */
    public function setJsonrpc($jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;
        return $this;
    }

    /**
     * @param string $method
     * @return RequestBuilder
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $params
     * @return RequestBuilder
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param int $id
     * @return RequestBuilder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getJsonrpc()
    {
        return $this->jsonrpc;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public static function create()
    {
        return new static();
    }


    public function toString() {
        $options = 0;
        if (defined('JSON_UNESCAPED_SLASHES')) {
            $options |= JSON_UNESCAPED_SLASHES;
        }
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $options |= JSON_UNESCAPED_UNICODE;
        }
        $jsonRpc = array(
                        'jsonrpc' => '2.0',
                        'method' => $this->method,
                        'params' => $this->params,
                        'id' => $this->id,
                    );
        return json_encode($jsonRpc, $options);
    }

    public function toArray() {
        $jsonRpc = array(
            'jsonrpc' => '2.0',
            'method' => $this->method,
            'params' => $this->params,
            'id' => $this->id,
        );
        return $jsonRpc;
    }


}