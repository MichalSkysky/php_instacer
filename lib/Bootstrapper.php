<?php

class Bootstrapper extends Object {
    static $base;

    function boot($args) {
        list($controller, $action, $params) = CLI ? $this->_handleCli($args) : $this->_handleHttp();

        return $controller()->call($action, $params);
    }

    protected function _handleHttp() {
        session_start();

        $url = array_diff(explode('/', substr(preg_replace('/\?.*$/', '', from($_SERVER, 'REQUEST_URI')), strlen(self::$base = substr(from($_SERVER, 'SCRIPT_NAME'), 0, -9)))), ['', null]);

        return [
            camelCase($url ? array_shift($url) : 'home') . 'Controller',
            lcfirst(camelCase($url ? array_shift($url) : 'index')),
            $url
        ];
    }

    protected function _handleCli($args) {
        return [
            'cliController',
            from($args, 1, 'start'),
            count($args) > 2 ? array_slice($args, 2) : []
        ];
    }
}
