<?php

spl_autoload_register(static function($class) {
    // replace namespace separators with directory separators in the relative
    // class name, append with .php
    $class_path = str_replace('\\', '/', $class);

    $file =  __DIR__ . '/src/' . $class_path . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});