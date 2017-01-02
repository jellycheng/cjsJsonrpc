<?php
namespace CjsJsonrpc\Core;

class Success {

    protected $rpcSuccess;

    public function __construct()
    {
        $this->rpcSuccess = new \stdClass;
        $this->result = '';

    }

    public static function create() {
        return new static();
    }

    /**
     * @return \stdClass
     */
    public function getRpcSuccess()
    {
        return $this->rpcSuccess;
    }


    public function setResult($data) {
        $this->rpcSuccess->result = $data;
        return $this;
    }

}