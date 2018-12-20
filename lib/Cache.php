<?php

!defined('CACHE_PATH') && define('CACHE_PATH', sys_get_temp_dir().'/');
class Cache
{
    // 驱动方式（支持filecache/memcache/secache）
    public static $type = 'secache';

    // 返回缓存实例
    protected static function instance()
    {
        static $instance = null;
        if (!is_null($instance)) {
            return $instance;
        }
        
        list($type, $config) = explode(':', self::$type, 2);

        $type = ucfirst($type) . 'Store';
        if (in_array($type, array('FilecacheStore', 'MemcacheStore', 'SecacheStore', 'RedisStore'))) {
            $file = str_replace("\\", "/", dirname(__FILE__)) . '/Store/'.$type.'.php';
            if ($type == 'SecacheStore') {
                include_once(str_replace("\\", "/", dirname(__FILE__)) . '/Secache.php');
            }
            include_once($file);
            $instance = new $type($config);
            return $instance;
        }
    }

    // 获取缓存
    public static function get($key, $default=null, $expire=99999999)
    {
        $value = self::instance()->get($key);
        if (!is_null($value)) {
            return $value;
        } elseif (is_callable($default)) {
            $value = $default();
            self::set($key, $value, $expire);
            return $value;
        } elseif (!is_null($default)) {
            self::set($key, $default, $expire);
            return $default;
        }
    }

    // 设置缓存
    public static function set($key, $value, $expire=99999999)
    {
        return self::instance()->set($key, $value, $expire);
    }

    // 清空缓存
    public static function clear()
    {
        return self::instance()->clear();
    }

    // 删除缓存
    public static function del($key)
    {
        return self::set($key, null);
    }

    // 判断缓存是否设置
    public static function has($key)
    {
        if (is_null(self::get($key))) {
            return false;
        } else {
            return true;
        }
    }
    // 读取并删除缓存
    public static function pull($key)
    {
        $value = self::get($key);
        self::del($key);
        return $value;
    }
}
