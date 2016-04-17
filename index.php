<?php

define('CLI', php_sapi_name() === 'cli');
define('DEBUG', true);

error_reporting(DEBUG ? E_ALL : 0);
ini_set('display_errors', DEBUG);

define('DIR', __DIR__ . '/');
define('LIB', DIR . 'lib/');
define('APP', DIR . 'app/');

require_once DIR . 'functions.php';

spl_autoload_register('autoload');
register_shutdown_function('shutdown');
update_instancers();

require_once DIR . 'instancers.php';

set_exception_handler([ErrorController(), 'handle']);
set_error_handler('error2exception');

Bootstrapper(CLI ? $argv : []);
