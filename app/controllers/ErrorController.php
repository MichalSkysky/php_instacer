<?php

class ErrorController extends Controller {
    function handle(Exception $e) {
        debug($e);
    }
}
