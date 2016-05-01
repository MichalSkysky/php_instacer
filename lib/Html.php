<?php

abstract class Html
{
    protected $_name;

    function __construct($name)
    {
        $this->_name = $name;
    }

    abstract function render();
}
