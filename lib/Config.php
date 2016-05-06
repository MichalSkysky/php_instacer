<?php

class Config
{
    private static $_instance;

    private $_data = [];

    private static function _getInstance()
    {
        return self::$_instance = self::$_instance ? self::$_instance : new self;
    }

    protected function __construct()
    {
        $this->_data = parse_ini_file(DIR . 'config.ini', true);
    }

    static function read($var)
    {
        return self::_getInstance()->_read($var);
    }

    protected function _read($var)
    {
        if (!strpos($var, '.')) {
            return from($this->_data, $var);
        }

        $section = explode('.', $var, 2);
        $var = $section[1];
        $section = $section[0];

        return from(from($this->_data, $section), $var);
    }
}
