<?php

define('CLI', php_sapi_name() === 'cli');
define('DEBUG', true);
define('DIR', __DIR__ . '/');
define('LIB', DIR . 'lib/');

require_once DIR . 'functions.php';

spl_autoload_register('autoload');
register_shutdown_function('shutdown');

DEBUG && update_instancers();
require_once DIR . 'instancers.php';

!CLI && Bootstrapper();
