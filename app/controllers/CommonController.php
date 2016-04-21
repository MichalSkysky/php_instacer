<?php

class CommonController extends Controller {
    function go($controller, $action = null, $params = []) {
        $this->_redirect(implode('/', func_get_args()));
    }
}
