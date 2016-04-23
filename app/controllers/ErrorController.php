<?php

class ErrorController extends Controller {
    static function handle(Exception $e) {
        debug($e);
    }
}
