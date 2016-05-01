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
        if ($this->_value !== null) {
            if (is_bool($this->_value)) {
                if ($this->_value === true) {
                    return ' ' . $this->_name;
                }
            } else {
                return ' ' . $this->_name . '="' . htmlspecialchars($this->_value) . '"';
            }
        }

    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param null $value
     */
    public function setValue($value)
    {
        $this->_value = $value;

        return $this;
    }

}
