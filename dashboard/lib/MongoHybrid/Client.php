<?php namespace MongoHybrid;
class Client
{
    public $type;
    protected $driver;

    public function __construct($server, $options = [], $driverOptions = [])
    {
        if (strpos($server, 'mongodb://') === 0 || strpos($server, 'mongodb+srv://') === 0) {
            $this->driver = new Mongo($server, $options, $driverOptions);
            $this->type = 'mongodb';
        }
        if (strpos($server, 'mongolite://') === 0) {
            $this->driver = new MongoLite($server, $options);
            $this->type = 'mongolite';
        }
    }

    public function dropCollection($name, $db = null)
    {
        return $this->driver->getCollection($name, $db)->drop();
    }

    public function renameCollection($name, $newname, $db = null)
    {
        return $this->driver->renameCollection($name, $newname, $db);
    }

    public function save($collection, &$data)
    {
        return $this->driver->save($collection, $data);
    }

    public function insert($collection, &$doc)
    {
        return $this->driver->insert($collection, $doc);
    }

    public function removeKey($collection, $key)
    {
        return $this->driver->remove($collection, ['key' => (is_array($key) ? ['$in' => $key] : $key)]);
    }

    public function keyExists($collection, $key)
    {
        return $this->driver->count($collection, ['key' => $key]);;
    }

    public function incrKey($collection, $key, $by = 1)
    {
        $current = $this->getKey($collection, $key, 0);
        $newone = $current + $by;
        $this->setKey($collection, $key, $newone);
        return $newone;
    }

    public function getKey($collection, $key, $default = null)
    {
        $entry = $this->driver->findOne($collection, ['key' => $key]);
        return $entry ? $entry['val'] : $default;
    }

    public function setKey($collection, $key, $value)
    {
        $entry = $this->driver->findOne($collection, ['key' => $key]);
        if ($entry) {
            $entry['val'] = $value;
        } else {
            $entry = ['key' => $key, 'val' => $value];
        }
        return $this->driver->save($collection, $entry);
    }

    public function decrKey($collection, $key, $by = 1)
    {
        return $this->incr($collection, $key, ($by * -1));
    }

    public function rpush($collection, $key, $value)
    {
        $list = $this->getKey($collection, $key, []);
        $list[] = $value;
        $this->setKey($collection, $key, $list);
        return count($list);
    }

    public function lpush($collection, $key, $value)
    {
        $list = $this->getKey($collection, $key, []);
        array_unshift($list, $value);
        $this->setKey($collection, $key, $list);
        return count($list);
    }

    public function lset($collection, $key, $index, $value)
    {
        $list = $this->getKey($collection, $key, []);
        if ($index < 0) {
            $index = count($list) - abs($index);
        }
        if (isset($list[$index])) {
            $list[$index] = $value;
            $this->setKey($collection, $key, $list);
            return true;
        }
        return false;
    }

    public function lindex($collection, $key, $index)
    {
        $list = $this->getKey($collection, $key, []);
        if ($index < 0) {
            $index = count($list) - abs($index);
        }
        return isset($list[$index]) ? $list[$index] : null;
    }

    public function hgetall($key)
    {
        $set = $this->getKey($collection, $key, []);
        return $set;
    }

    public function hexists($collection, $key, $field)
    {
        $set = $this->getKey($collection, $key, []);
        return isset($set[$field]);
    }

    public function hvals($key)
    {
        $set = $this->getKey($collection, $key, []);
        return array_values($set);
    }

    public function hlen($key)
    {
        return count($this->hkeys($key));
    }

    public function hkeys($key)
    {
        $set = $this->getKey($collection, $key, []);
        return array_keys($set);
    }

    public function hdel($key)
    {
        $set = $this->getKey($collection, $key, []);
        if (!count($set)) return 0;
        $fields = func_get_args();
        $removed = 0;
        for ($i = 1; $i < count($fields); $i++) {
            $field = $fields[$i];
            if (isset($set[$field])) {
                unset($set[$field]);
                $removed++;
            }
        }
        $this->setKey($collection, $key, $set);
        return $removed;
    }

    public function hincrby($collection, $key, $field, $by = 1)
    {
        $current = $this->hget($collection, $key, $field, 0);
        $newone = $current + $by;
        $this->hset($collection, $key, $field, $newone);
        return $newone;
    }

    public function hget($collection, $key, $field, $default = null)
    {
        $set = $this->getKey($collection, $key, []);
        return isset($set[$field]) ? $set[$field] : $default;
    }

    public function hset($collection, $key, $field, $value)
    {
        $set = $this->getKey($collection, $key, []);
        $set[$field] = $value;
        $this->setKey($collection, $key, $set);
    }

    public function hmget($key)
    {
        $set = $this->getKey($collection, $key, []);
        $fields = func_get_args();
        $values = [];
        for ($i = 1; $i < count($fields); $i++) {
            $field = $fields[$i];
            $values[] = isset($set[$field]) ? $set[$field] : null;
        }
        return $values;
    }

    public function hmset($key)
    {
        $set = $this->getKey($collection, $key, []);
        $args = func_get_args();
        for ($i = 1; $i < count($fields); $i++) {
            $field = $args[$i];
            $value = isset($args[($i + 1)]) ? $args[($i + 1)] : null;
            $set[$field] = $value;
            $i = $i + 1;
        }
        $this->setKey($collection, $key, $set);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->driver, $method], $args);
    }
}