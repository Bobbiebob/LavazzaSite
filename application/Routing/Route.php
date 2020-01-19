<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 10:59
 */

namespace Application\Routing;

class Route
{
    private static function add($request_type, $uri, $controller) {
        $GLOBALS['routes'][$request_type][] = [
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public static function get($uri, $controller) {
        return self::add('GET', $uri, $controller);
    }

    public static function post($uri, $controller) {
        return self::add('GET', $uri, $controller);
    }
}