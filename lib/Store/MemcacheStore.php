<?php 

class MemcacheStore
{
    private $m;
    
    public function __construct($config = null)
    {
        $this->m = new Memcache();
        if (empty($config)) {
            $config = 'localhost:11211';
        }
        list($host, $port) = explode(':', $config, 2);
        $this->m->addServer($host, $port);
    }

    public function get($key)
    {
        $data = $this->m->get($key);
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
        return $this->m->set($key, $data);
    }

    public function clear()
    {
        $this->m->flush(10);
    }
}
