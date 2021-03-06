<?php

class Html_Attribute extends Html
{
    protected $_value;

    function __construct($name, $value = null)
    {
        parent::__construct($name);

        $this->_value = $value;
    }

    function render()
    {
        $return = null;

        if ($this->_value !== null) {
            if (is_bool($this->_value)) {
                if ($this->_value === true) {
                    $return = ' ' . $this->_name;
                }
            } else {
                $return = ' ' . $this->_name . '="' . htmlspecialchars($this->_value) . '"';
            }
        }

        return $return;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setValue($value)
    {
        $this->_value = $value;

        return $this;
    }

}
