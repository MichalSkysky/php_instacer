<?php

/**
 * @method static Session getInstance()
 */
class Session
{
    use Singleton;

    public static function start()
    {
        self::getInstance()->_start();
    }

    public static function regenerate()
    {
        self::getInstance()->_regenerate();
    }

    public static function stop()
    {
        self::getInstance()->_stop();
    }

    private function _start()
    {
        if (!$this->_isStarted()) {
            session_start();
        }
    }

    public static function check($key)
    {
        return self::getInstance()->_has($key);
    }

    public static function read($key = null)
    {
        return self::getInstance()->_read($key);
    }

    public static function write($key = null, $value)
    {
        self::getInstance()->_write($key, $value);
    }

    public static function delete($key)
    {
        self::getInstance()->_delete($key);
    }


    private function _delete($key)
    {
        Utils::deepDelete($key, $_SESSION);
    }


    private function _read($key = null)
    {
        if (!$this->isStarted()) {
            return null;
        }

        if ($key) {
            return Utils::deepRead($key, $_SESSION);
        }

        return $_SESSION;
    }


    public static function isStarted()
    {
        return self::getInstance()->_isStarted();
    }

    private function _isStarted()
    {
        return !empty(session_id());
    }

    private function _has($key)
    {
        if (!$this->isStarted()) {
            return false;
        }

        return Utils::deepCheck($key, $_SESSION);
    }

    private function _write($key, $value)
    {
        if ($this->isStarted()) {
            Utils::deepWrite($key, $_SESSION, $value);
        }
    }

    private function _stop()
    {
        if ($this->isStarted()) {
            session_unset();
            session_destroy();
        }
    }

    private function _regenerate()
    {
        if ($this->isStarted()) {
            session_regenerate_id();
        }
    }
}
