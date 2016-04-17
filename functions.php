<?php

function autoload($class) {
    $file = str_replace('_', '/', $class) . '.php';

    foreach ([LIB, APP.'models/', APP.'views/', APP.'controllers/'] as $path)
        if (import($path.$file))
            break;
}

function error2exception($no, $msg, $file, $line) {
    throw new ErrorException($msg, 0, $no, $file, $line);
}

function shutdown() {
    // do shutdown stuff
}

function update_instancers() {
    if (!DEBUG && file_exists(DIR.'instancers.php'))
        return;

    $nativeClasses = get_declared_classes();
    array_map('import', array_merge(r_scan(APP), r_scan(LIB)));
    $instancers = [];
    $clean = function ($param) {
        return str_replace('NULL', 'null', preg_replace('/\d+ => /', '', str_replace(['array ( ', ', )'], ['[', ']'], preg_replace('/[\s\r\n\t]+/', ' ', $param))));
    };

    foreach (array_diff(get_declared_classes(), $nativeClasses) as $className) {
        $class = new ReflectionClass($className);

        if ($class->isInstantiable()) {
            $constructor = $class->getConstructor();

            if ($constructor && !$constructor->isInternal()) {
                $params = [];

                foreach ($constructor->getParameters() as $parameter) {
                    $type = $parameter->isArray() ? 'array ' : ($parameter->getClass() ? $parameter->getClass()->getName() . ' ' : '');
                    $reference = $parameter->isPassedByReference() ? '&' : '';
                    $name = '$'.$parameter->getName();
                    $value = $parameter->isOptional() ? ' = ' . $clean(var_export($parameter->getDefaultValue(), true)) : '';

                    $params[$name] = $type.$reference.$name.$value;
                }

                $paramNames = implode(', ', array_keys($params));
                $params = implode(', ', $params);

                $instancers[$className] = "function $className($params) { return new $className($paramNames); }";
            } else {
                $instancers[$className] = "function $className() { return new $className; }";
            }
        }
    }

    ksort($instancers);

    file_put_contents(DIR.'instancers.php', "<?php\n\n".implode("\n", $instancers));
}

function debug($arg = null) {
    if (!DEBUG) return;

    echo CLI ?: '<pre>';

    foreach (func_get_args() as $arg) {
        is_array($arg) || is_object($arg) ? print_r($arg) : var_dump($arg);
    }

    echo CLI ?: '</pre>';
}

function import ($file) {
    return (bool) file_exists($file) ? require_once $file : false;
}

function from($arr, $key, $default = null) {
    return is_array($arr) && array_key_exists($key, $arr) ? $arr[$key] : $default;
}

function r_scan($dir) {
    $files = [];

    foreach (array_diff(scandir($dir), ['.', '..']) as $file) {
        $path = "$dir/$file";

        if (is_dir($path)) {
            $files = array_merge($files, r_scan($path));
        } else {
            $files[] = $path;
        }
    }

    return $files;
}

function camelCase($string, $sep = '-') {
    return implode('', array_map('ucfirst', explode($sep, $string)));
}
