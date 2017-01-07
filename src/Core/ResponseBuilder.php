<?php
namespace CjsJsonrpc\Core;

class ResponseBuilder {

    protected $jsonrpc = '2.0';
    protected $result;  //当发生错误时,一定不返回这个key
    protected $id = 0;
    protected $error;

    protected $isError = false;


    public static function create() {
       return new static();
    }

    public function response() {

        if($this->isError) {
            $res = $this->buildError();
        } else {
            $res = $this->buildSuccess();
        }
        $options = 0;
        if (defined('JSON_UNESCAPED_SLASHES')) {
            $options |= JSON_UNESCAPED_SLASHES;
        }
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $options |= JSON_UNESCAPED_UNICODE;
        }
        return json_encode($res, $options);
    }


    protected function buildSuccess() {
        $response = [
                    'jsonrpc' => $this->jsonrpc,
                    'result'=>$this->result,
                    'id'=>$this->id,
                    ];
        return $response;
    }


    protected function buildError() {
        $response = [
            'jsonrpc' => $this->jsonrpc,
            'error'=>$this->error,
            'id'=>$this->id,
        ];
        return $response;

    }

    /**
     * @param string $jsonrpc
     * @return ResponseBuilder
     */
    public function setJsonrpc($jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;
        return $this;
    }

    /**
     * @param mixed $result
     * @return ResponseBuilder
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @param int $id
     * @return ResponseBuilder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $error
     * @return ResponseBuilder
     */
    public function setError($error)
    {
        if($error instanceof Error) {
            $error = $error->toArray();
        }
        $this->error = $error;
        return $this;
    }

    /**
     * @param boolean $isError
     * @return ResponseBuilder
     */
    public function setIsError($isError)
    {
        $this->isError = $isError;
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
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return boolean
     */
    public function getIsError()
    {
        return $this->isError;
    }

    /**
     * @param $errorData = ['code'=>'', 'message'=>'', 'data'=>''] or 'code'
     * @return static
     */
    public static function error($errorData)
    {
        $errorObj = Error::create();

        if (is_array($errorData)) {
            $errorObj->setCode($errorData['code']);

            if (array_key_exists('message', $errorData)) {
                $errorObj->setMessage($errorData['message']);
            }

            if (array_key_exists('data', $errorData)) {
                $errorObj->setData( $errorData['data']);
            }
        } else {
            $errorObj->setCode($errorData);
        }
        return $errorObj;

    }



}