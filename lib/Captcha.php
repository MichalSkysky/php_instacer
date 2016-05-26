<?php

class Captcha extends Image
{
    protected $_randomString;

    public function __construct($x, $y)
    {
        parent::__construct($x, $y);

        $this->_randomString = $this->getRandomString();

        if (Session::isStarted()) {
            if (Session::check('captcha.id')) {
                Session::delete(Session::read('captcha.id'));
            }

            Session::write('captcha.id', uniqid('captcha.'));
            Session::write(Session::read('captcha.id'), $this->_randomString);
        }

        debug($_SESSION);
        die;
    }

    private function getRandomString()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = rand(4, 8);
        $string = '';

        while (strlen($string) < $length) {
            $char = $chars[rand(0, strlen($chars) - 1)];

            if (rand(0, 1)) {
                $char = strtoupper($char);
            }

            $string .= $char;
        }

        return $string;
    }

}
