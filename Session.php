<?php namespace Flatphp\Session;

use Flatphp\Cache\Cache;

/**
 * config e.g.
 * [
 *     'lifetime' => 1440,
 *     'handler' => 'cache'
 * ]
 */
class Session
{
    // check if started
    protected static $_started = 0;
    protected static $config = [];


    public static function init(array $config)
    {
        if (empty($config['lifetime'])) {
            $config['lifetime'] = (int)ini_get('session.gc_maxlifetime');
        }
        self::$config = $config;
    }

    /**
     * Create cache handler
     * @return CacheHandler
     */
    protected static function createCacheHandler()
    {
        return new CacheHandler(Cache::getAdapter(), self::$config['lifetime']);
    }


    /**
     * session start
     */
    public static function start()
    {
        if (self::$_started) {
            return;
        }
        if (!empty(self::$config['handler'])) {
            $method = 'create'. ucfirst(strtolower(self::$config['handler'])) .'Handler';
            session_set_save_handler(self::$method());
        }

        self::$_started = session_start();
    }


    /**
     * Get session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Set session
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Check if has session
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Delete session
     * @param $key
     */
    public static function delete($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Get session id
     * @return string
     */
    public static function getId()
    {
        self::start();
        return session_id();
    }

    /**
     * Close session write
     */
    public static function close()
    {
        self::start();
        session_write_close();
    }

    /**
     * Session destroy
     */
    public static function destroy()
    {
        self::start();
        session_unset();
        session_destroy();
    }
}