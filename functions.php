<?php

function autoload($class) {
    $file = str_replace('_', '/', $class) . '.php';

    foreach ([LIB, APP.'models/', APP.'views/', APP.'controllers/'] as $path)
        if (import($path.$file))
            return;

    eval("class $class{function __construct(){throw new Exception('unknown class $class');}}");
}

function error2exception($no, $msg, $file, $line) {
    throw new ErrorException($msg, 0, $no, $file, $line);
}

function shutdown() {
    // do shutdown stuff
}

function debug($arg = null) {
    if (!DEBUG) return;

    echo CLI ? '' : '<pre>';

    foreach (func_get_args() as $arg) {
        is_array($arg) || is_object($arg) ? print_r($arg) : var_dump($arg);
    }

    echo CLI ? '' : '</pre>';
}

function import($file) {
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

function camel_case($string, $sep = '-') {
    return implode('', array_map('ucfirst', explode($sep, $string)));
}

function snake_case($string, $sep = '_') {
    return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
}
