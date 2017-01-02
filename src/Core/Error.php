<?php
namespace CjsJsonrpc\Core;

class Error {

    protected $rpcError;

    public function __construct()
    {
        $this->rpcError          = new \stdClass;
        $this->rpcError->code    = 0;
        $this->rpcError->message = '';
        // This may be omitted.
        // $this->rpcError->data    = null;
    }

    public static function create() {
        return new static();
    }

    /**
     * @return \stdClass
     */
    public function getRpcError()
    {
        return $this->rpcError;
    }

    public function setCode($code) {
        $this->rpcError->code = $code;
        return $this;
    }

    public function setMessage($message) {
        $this->rpcError->message = $message;
        return $this;
    }

    public function setData($data) {
        $this->rpcError->data = $data;
        return $this;
    }

    public function toArray() {
        $res = [
                'code'=>$this->getRpcError()->code,
                'message'=>$this->getRpcError()->message,
                ];
        if(property_exists($this->getRpcError(), 'data')) {
            $res['data'] = $this->getRpcError()->message;
        }
        return $res;
    }


}