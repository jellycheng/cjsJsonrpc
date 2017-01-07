<?php
namespace CjsJsonrpc\Util;

class ObjectId
{
    private $id;
    private static $mathine_id;
    private static $pid_part;

    public static function create($id = null)
    {
        return new static($id);
    }

    public function __construct($id = null)
    {
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = self::generate();
        }
    }

    private static function getMachineId()
    {
        if (!isset(self::$mathine_id)) {
            self::$mathine_id = substr(md5(getHostName()), 0, 6);
        }

        return self::$mathine_id;
    }

    private static function getPidPart()
    {
        if (!isset(self::$pid_part)) {
            self::$pid_part = getmypid() & 0xFFFF;
        }

        return self::$pid_part;
    }

    private static function nextCounter()
    {
        return mt_rand(0, 0xFFFFFF);
    }

    public static function generate()
    {
        return unpack(
            'H24',
            pack('NH3nN', time() & 0xFFFFFFFF, self::getMachineId(), self::getPidPart(), self::nextCounter())
        )[1];
    }

    public function getId() {
        return $this->id?:'0';
    }

    public function __toString()
    {
        return $this->getId();
    }

}
