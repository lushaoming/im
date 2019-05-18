<?php
/**
 * Redis操作
 */
namespace App\Http\Common;

class RedisWriter
{
	private $redis = null;
	public static $_instance = null;
	private function __construct(){
        if (is_null($this->redis)) {
            $this->redis = new \Redis();
            $this->redis->connect('127.0.0.1', 6379);
        }
    }

	public static function getIntance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new RedisWriter();
        }
        return self::$_instance;
    }

    public function write($key, $value, $expire = 0)
    {
        $this->redis->set($key, $value, $expire);
    }

    public function read($key)
    {
        return $this->redis->get($key);
    }

    /**
     * @param string|array $key 删除的键名，支持数组批量删除
     */
    public function delete($key)
    {
        $this->redis->del($key);
    }
}