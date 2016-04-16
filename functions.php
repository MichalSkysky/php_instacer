<?php

function autoload($class) {
    import(LIB . str_replace('_', '/', $class) . '.php');
}

function shutdown() {
    // do shutdown stuff
}

function update_instancers() {
    $nativeClasses = get_declared_classes();
    array_map('import', r_scan(LIB));
    $instancers = [];
    $clean = function ($param) {
        return preg_replace('/\d+ => /', '', str_replace(['array ( ', ', )'], ['[', ']'], preg_replace('/[\s\r\n\t]+/', ' ', $param)));
    };

    foreach (array_diff(get_declared_classes(), $nativeClasses) as $className) {
        $class = new ReflectionClass($className);

        if ($class->isInstantiable()) {
            $constructor = $class->getConstructor();

            if ($constructor) {
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
    require_once $file;
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
