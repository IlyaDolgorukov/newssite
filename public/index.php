<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

session_start();

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('PUBLIC', ROOT . '/public');

spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

function sc()
{
    return \core\Application::getInstance();
}

sc()->dispatch();
