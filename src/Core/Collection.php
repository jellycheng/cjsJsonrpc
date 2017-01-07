<?php
namespace CjsJsonrpc\Core;

use Closure;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class Collection implements ArrayAccess, IteratorAggregate {

    protected $items = array();

    public function __construct($items = array())
    {
        $items = is_null($items) ? [] : $this->getArrayableItems($items);

        $this->items = (array) $items;
    }


    public static function create($items = null)
    {
        return new static($items);
    }

    public function set($key, $val)
    {
        $this->offsetSet($key, $val);
    }

    public function get($key, $default = null)
    {
        if ($this->offsetExists($key))
        {
            return $this->items[$key];
        }

        return $default instanceof Closure ? $default() : $default;
    }

    protected function getArrayableItems($items)
    {
        if ($items instanceof Collection)
        {
            $items = $items->all();
        }

        return $items;
    }

    public function all()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->items[] = $value;
        }
        else
        {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }


}
