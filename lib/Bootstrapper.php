<?php

class Bootstrapper extends Object {
    function __construct($args) {
        list($controller, $action, $params) = CLI ? $this->_handleCli($args) : $this->_handleHttp();

        call_user_func_array([$controller(), $action], $params);
    }

    protected function _handleHttp() {
        session_start();

        $url = array_diff(explode('/', substr(from($_SERVER, 'REQUEST_URI'), strlen(substr(from($_SERVER, 'SCRIPT_NAME'), 0, -9)))), ['', null]);

        return [
            camelCase($url ? array_shift($url) : 'home') . 'Controller',
            camelCase($url ? array_shift($url) : 'index'),
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
