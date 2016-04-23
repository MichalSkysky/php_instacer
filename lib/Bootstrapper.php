<?php

class Bootstrapper extends Object {
    static $base;

    /**
     * @var Controller
     */
    protected $_controller;

    protected $_action;

    protected $_params = [];

    function __construct($args = []) {
        CLI ? $this->_handleCli($args) : $this->_handleHttp();

        echo $this->_controller->call($this->_action, $this->_params);
    }

    protected function _handleHttp() {
        session_start();

        $url = array_diff(explode('/', substr(preg_replace('/\?.*$/', '', from($_SERVER, 'REQUEST_URI')), strlen(self::$base = substr(from($_SERVER, 'SCRIPT_NAME'), 0, -9)))), ['', null]);
        $controller = camelCase($url ? array_shift($url) : 'home') . 'Controller';

        $this->_controller = new $controller;
        $this->_action = lcfirst(camelCase($url ? array_shift($url) : 'index'));
        $this->_params = $url;
    }

    protected function _handleCli($args) {
        $this->_controller = new CliController;
        $this->_action = from($args, 1, 'start');
        $this->_params = count($args) > 2 ? array_slice($args, 2) : [];
    }
}
