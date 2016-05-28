<?php

class Utils {
    static function toArray($value) {
        if ($value === null)
            return [];
        elseif (is_array($value))
            return $value;
        return [$value];
    }

    static function toHex($int, $length) {
        $hex = dechex($int);

        while (strlen($hex) < $length) {
            $hex = '0' . $hex;
        }

        return $hex;
    }

    static function deepWrite($key, &$target, $value) {
        eval('$target[\'' . str_replace('.', "']['", $key) . '\'] = $value;');
    }

    static function deepDelete($key, &$target) {
        eval('unset($target[\'' . str_replace('.', "']['", $key) . '\']);');
    }

    static function deepRead($key, $target) {
        if (!is_array($target)) {
            return null;
        }

        foreach (explode('.', $key) as $key) {
            if (!array_key_exists($key, $target)) {
                return null;
            }

            $target = $target[$key];
        }

        return $target;
    }

    static function deepCheck($key, $target) {
        if (!is_array($target)) {
            return false;
        }

        foreach (explode('.', $key) as $key) {
            if (!array_key_exists($key, $target)) {
                return false;
            }

            $target = $target[$key];
        }

        return true;
    }
}
