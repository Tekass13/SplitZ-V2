<?php

spl_autoload_register(function ($class_name) {
    // Convert namespace to full file path
    $file = __DIR__ . '/' . str_replace('\\', '/', $class_name) . '.php';

    // Check if the file exists before requiring it
    if (file_exists($file)) {
        require_once $file;
    }
});