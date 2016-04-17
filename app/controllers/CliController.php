<?php

class CliController extends Controller {
    function test() {
        debug(func_get_args());
    }
}
