<?php

class Utils {
    static function toArray($value) {
        if ($value === null)
            return [];
        elseif (is_array($value))
            return $value;
        return [$value];
    }
}
