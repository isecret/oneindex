<?php

class SecacheStore
{
    private $cachefile;
    private $c;
    
    public function __construct($config=null)
    {
        list($cachefile, $size) = explode(':', $config, 2);
        
        if (empty($cachefile)) {
            $cachefile = CACHE_PATH.'cachedata';
        }

        if (empty($size)) {
            $size = '100M';
        }

        define('SECACHE_SIZE', $size);
        $this->cachefile = $cachefile;
        $this->c = new Secache();
        $this->c->workat($this->cachefile);
    }

    public function get($key)
    {
        $this->c->fetch(md5($key), $data);
        if (is_array($data) && $data['expire'] > time() && !is_null($data['data'])) {
            return $data['data'];
        } else {
            return null;
        }
    }

    public function set($key, $value=null, $expire=99999999)
    {
        $data['expire'] = time() + $expire;
        $data['data'] = $value;
        return $this->c->store(md5($key), $data);
    }

    public function clear()
    {
        return $this->c->clear();
    }
}
