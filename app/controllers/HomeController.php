<?php

class HomeController extends CommonController {

    protected $_hasModel = true;

    protected $_hasView = true;

    function index() {
        return $this->_view->render('home/index');
    }

    function goHome() {
        $this->_redirect('home/index');
    }
}
