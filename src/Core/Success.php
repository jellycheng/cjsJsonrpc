<?php
namespace CjsJsonrpc\Core;

class Success {

    protected $rpcSuccess;

    public function __construct()
    {
        $this->rpcSuccess = new \stdClass;
        $this->rpcSuccess->result = '';
        $this->rpcSuccess->id = null;
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

    public function setId($id) {
        $this->rpcSuccess->id = $id;
        return $this;
    }

}