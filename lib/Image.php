<?php

class Image
{
    const TYPE_PNG = 'png';

    protected $_x;

    protected $_y;

    protected $_background;

    protected $_type = self::TYPE_PNG;

    public function __construct($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function setBackground(Color $color)
    {
        $this->_background = $color;

        return $this;
    }

    public function render()
    {
        $img = imagecreatetruecolor($this->_x, $this->_y);

        if ($this->_background) {
            $backgroundColor = $this->_background->allocate($img);
            imagefill($img, 0, 0, $backgroundColor);
        }

        ob_start();

        call_user_func('image' . $this->_type, $img);

        $output = ob_get_clean();

        imagedestroy($img);

        return $output;
    }

    public function output()
    {
        header('Content-Type: image/' . $this->_type);
        echo $this->render();
        die;
    }

    public function __toString()
    {
        try {
            return $this->output();
        } catch (Exception $e) {
            return get_class($e) . ': ' . $e->getMessage();
        }
    }

}
