<?php
namespace CjsJsonrpc\Util;

class Errorable
{
    private $_errstr = '';
    private $_errno = 0;

    public function errno()
    {
        return $this->_errno;
    }

    public function errstr()
    {
        return $this->_errstr;
    }

    protected function clearErr()
    {
        $this->setErr('', 0);
    }

    protected function setErr($errno, $errstr)
    {
        $this->_errstr = $errstr;
        $this->_errno  = $errno;
    }

}
