<?php

class CliController extends Controller {
    function test() {
        debug(func_get_args());
    }

    function start() {
        debug(function_exists('yaml_parse'));
    }

    protected function _access() {
        return CLI;
    }
}
