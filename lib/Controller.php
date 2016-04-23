<?php

abstract class Controller extends Object {

    protected $_hasModel = false;

    protected $_hasView = false;

    /**
     * @var Model
     */
    protected $_model;

    /**
     * @var View
     */
    protected $_view;

    function getShortName() {
        return substr(get_class($this), 0, -10);
    }

    function __construct() {
        if (!$this->_access()) {
            throw new Exception('Access denied');
        }

        if ($this->_hasModel) {
            $this->_model = $this->getShortName();
            $this->_model = new $this->_model;
        }

        if ($this->_hasView) {
            $this->_view = $this->getShortName() . 'View';
            $this->_view = new $this->_view;
        }
    }

    protected function _access() {
        return true;
    }

    function call($action, array $params) {
        if (method_exists($this, $action) && !method_exists('Controller', $action)) {
            return call_user_func_array([$this, $action], $params);
        } else {
            throw new Exception("invalid action $action");
        }
    }

    protected function _redirect($url) {
        header('Location: ' . Bootstrapper::$base . $url);
        exit;
    }
}
