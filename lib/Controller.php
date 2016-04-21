<?php

abstract class Controller extends Object {
    function __construct() {
        if (!$this->_access()) {
            throw new Exception('Access denied');
        }
    }

    protected function _access() {
        return true;
    }

}
