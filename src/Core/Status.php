<?php
namespace CjsJsonrpc\Core;

class Status
{
    const SUCCESS            = 0;
    const PARSE_ERROR        = -32700;
    const INVALID_REQUEST    = -32600;
    const METHOD_NOT_EXISTS  = -32601;
    const INVALID_PARAMS     = -32602;
    const INTERNAL_ERROR     = -32603;

    public static function desc($code)
    {
        $ret = 'unknown error';

        switch ($code) {
            case self::SUCCESS:
                $ret = 'success';
                break;
            case self::PARSE_ERROR:
                $ret = 'invalid request was received by the server';
                break;
            case self::INVALID_REQUEST:
                $ret = 'The sent is not a valid request object';
                break;
            case self::METHOD_NOT_EXISTS:
                $ret = 'The method does not exist / is not available';
                break;
            case self::INVALID_PARAMS:
                $ret = 'invalid method parameter(s)';
                break;
            case self::INTERNAL_ERROR:
                $ret = 'internal error';
                break;
        }

        return $ret;
    }
}
