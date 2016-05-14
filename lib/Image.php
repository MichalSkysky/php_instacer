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

    public function setBackground($r, $g, $b, $a = null)
    {
        $this->_background = func_get_args();

        return $this;
    }

    public function render()
    {
        $img = imagecreatetruecolor($this->_x, $this->_y);

        if ($this->_background) {
            if (count($this->_background) == 3) {
                $backgroundColor = call_user_func_array('imagecolorallocate', array_merge([$img], $this->_background));
            } else {
                $backgroundColor = call_user_func_array('imagecolorallocatealpha', array_merge([$img], $this->_background));
            }

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
