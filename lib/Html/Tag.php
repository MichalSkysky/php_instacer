<?php

class Html_Tag extends Html
{
    static $_selfClosing = ['base', 'input', 'link', 'meta', 'br'];

    /**
     * @var Html_Attribute[]
     */
    protected $_attributes = [];

    /**
     * @var Html_Tag[]
     */
    protected $_children = [];

    function addAttribute(Html_Attribute $attribute)
    {
        $this->_attributes[] = $attribute;

        return $this;
    }

    function addChild(Html_Tag $child)
    {
        $this->_children[] = $child;

        return $this;
    }

    function render()
    {
        $tag = '<' . $this->_name;

        foreach ($this->_attributes as $attribute) {
            $tag .= $attribute->render();
        }

        $tag .= '>';

        if (!in_array($this->_name, self::$_selfClosing)) {
            foreach ($this->_children as $child) {
                $tag .= $child->render();
            }

            $tag .= '</' . $this->_name . '>';
        }

        return $tag;
    }

}
