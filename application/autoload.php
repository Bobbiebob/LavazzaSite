<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 10:26
 */

class Autoloader
{
    public static function init()
    {
        spl_autoload_register('Autoloader::load');
    }
    public static function load($class)
    {
        $parts = explode('\\', $class);
        array_shift($parts);
        $path = APPDIR . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, $parts) . '.php';
        if (!file_exists($path)) {
            throw new Exception('Namespacing or classname is invalid.');
        }
        require $path;
    }
}

// call
Autoloader::init();