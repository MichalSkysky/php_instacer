<?php

class CatchaController extends Controller
{
    public function generate()
    {
        return new Captcha(300, 150);
    }
}
