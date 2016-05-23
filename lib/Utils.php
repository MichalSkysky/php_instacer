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
}
