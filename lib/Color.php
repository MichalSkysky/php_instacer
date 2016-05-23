<?php

class Color
{
    public $r;
    public $g;
    public $b;
    public $a;

    /**
     * @param int $r red
     * @param int $g green
     * @param int $b blue
     * @param float $a in %
     */
    public function __construct($r, $g, $b, $a)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->a = $a;
    }

    public function allocate($img)
    {
        return imagecolorallocatealpha($img, $this->r, $this->g, $this->b, $this->a * 127);
    }

    function __toString()
    {
        return '#' . $this->r . $this->g . $this->b . '@' . ($this->a * 100) . '%';
    }

    function toRgba()
    {
        return 'rgba(' . $this->r . ', ' . $this->g . ', ' . $this->b . ', ' . $this->a . ')';
    }

    function toRgb()
    {
        return '#' . Utils::toHex($this->r, 2) . Utils::toHex($this->g, 2) . Utils::toHex($this->b, 2);
    }


}
