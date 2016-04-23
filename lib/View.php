<?php

abstract class View extends Object {

    protected $_vars = [];

    protected $_base = 'index';

    protected $_scripts = [
        'jquery',
        'script'
    ];

    protected $_styles = [
        'style'
    ];

    function set($var, $val) {
        $this->_vars[$var] = $val;

        return $this;
    }

    function addStyle($file) {
        $this->_styles[] = $file;

        return $this;
    }

    function addScript($file) {
        $this->_scripts[] = $file;

        return $this;
    }

    function get($var) {
        return from($this->_vars, $var);
    }

    function render($template) {
        return $this->set('template', $this->_loadTemplate($template))->_loadTemplate($this->_base);
    }

    protected function _loadTemplate($template) {
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
