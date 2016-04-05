<?php

/**
 * Class MyClass
 */
class MyClass {
    /**
     * @return MyClass
     */
    static function create() {
        return new self;
    }
}

/**
 * @return MyClass
 */
function MyClass() {
    return new MyClass();
}

// classic
$MyClass = new MyClass();

// factory
$MyClass = MyClass::create();

// instancer
$MyClass = MyClass();
