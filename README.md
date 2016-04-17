#PHP Instancer Framework

This project will introduce you to the Instancer pattern, an alternative for those not
too fond of features such as namespaces, independent on most foreign libraries and in
search for a slim and nice solution.

##Internal Coding Guidelines

###General
- KISS
    - Write as little as possible
- YAGNI
    - Write only what you need
- DRY
    - You need something twice, export it

###Functions
- snake_case &rarr; my_custom_function()
- functions.php

###Classes
- CamelCase &rarr; My_Custom_Class
- Path_To_ClassName -> LIB + Path/To/ClassName.php
- private / protected leading underscore &rarr; protected function _internalStuff()

###MVC
- C knows M + V
- M and V don't know anything beside their respective components
