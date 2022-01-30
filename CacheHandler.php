<?php namespace Flatphp\Session;

use SessionHandlerInterface;
use Flatphp\Cache\Adapter\AdapterInterface;

class CacheHandler implements SessionHandlerInterface
{
    /**
     * @var AdapterInterface|null
     */
    protected $cache = null;
    protected $lifetime = 1440;

    public function __construct(AdapterInterface $cache, $lifetime)
    {
        $this->cache = $cache;
        $this->lifetime = $lifetime;
    }

    /**
     * @inheritdoc
     */
    public function open($save_path, $session_id):bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function read($session_id):string|false
    {
        return $this->cache->get($session_id, '');
    }

    /**
     * @inheritdoc
     */
    public function write($session_id, $session_data):bool
    {
        return $this->cache->set($session_id, $session_data, $this->lifetime);
    }

    /**
     * @inheritdoc
     */
    public function close():bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function destroy($session_id):bool
    {
        return $this->cache->delete($session_id);
    }

    /**
     * @inheritdoc
     */
    public function gc($maxlifetime):int|false
    {
        return 1;
    }
}