<?php
namespace CjsJsonrpc\Util;

class Curl {

    public function __construct($curlOption = [])
    {

    }

    public static function create($curlOption = [])
    {

        return new static($curlOption);
    }

}