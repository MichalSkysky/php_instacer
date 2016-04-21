<?php

abstract class View extends Object {

    protected $_vars = [];

    protected $_base = 'index';

    function set($var, $val) {
        $this->_vars[$var] = $val;

        return $this;
    }

    function get($var) {
        return from($this->_vars, $var);
    }

    function render($template) {
        return $this->set('template', $this->_loadTemplate($template))->_loadTemplate($this->_base);
    }

    function _loadTemplate($template) {
        ob_start();

        try {
            include APP . "views/templates/$template.phtml";
            return ob_get_clean();
        } catch (Exception $e) {
            ob_end_clean();
            return $e->getMessage();
        }
    }
}
