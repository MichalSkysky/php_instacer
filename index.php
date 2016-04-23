<?php

define('CLI', PHP_SAPI === 'cli');
define('DEBUG', true);
define('DIR', __DIR__ . '/');
define('LIB', DIR . 'lib/');
define('APP', DIR . 'app/');

require_once DIR . 'functions.php';

error_reporting(DEBUG ? E_ALL : 0);
ini_set('display_errors', DEBUG);
spl_autoload_register('autoload');
register_shutdown_function('shutdown');
set_error_handler('error2exception');
set_exception_handler([new ErrorController, 'handle']);

new Bootstrapper(CLI ? $argv : []);
