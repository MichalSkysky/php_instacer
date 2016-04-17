<?php

class ErrorController {
    function handle(Exception $e) {
        debug($e);
    }
}
