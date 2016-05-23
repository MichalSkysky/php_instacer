<?php

class CaptchaController extends Controller
{
    public function generate()
    {
        return (new Captcha(300, 150))->setBackground(new Color(150, 50, 50, .5));
    }
}
