<?php
namespace Application\Routing;
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 10:57
 */

class Router
{

    public static function getURI() {
        $uri = strtok($_SERVER["REQUEST_URI"],'?');
        $uri = trim($uri, '/');

        return $uri;
    }

    public static function dispatch()
    {
//        $uri = $_SERVER['REQUEST_URI'];
        $uri = self::getURI();

        foreach ($GLOBALS['routes'][$_SERVER['REQUEST_METHOD']] as $route)
        {
            $regexPattern = '#^' . preg_replace('#{([\w-]+)}#', '(?P<$1>[\w-]+)', $route['uri']) . '$#';
            if (preg_match($regexPattern, $uri, $parameters))
            {
                $parameters = array_filter($parameters, function ($key) {
                    return !is_int($key);
                }, ARRAY_FILTER_USE_KEY);

                $controller = $route['controller'];
                $parts = explode('@', $controller);
                $class = 'Application\Controllers\\' . $parts[0];

                try {
                    if(!class_exists($class)) {
                        self::terminate();
                    }

                    $controller = new $class;
                    $method = $parts[1];

                    if(!method_exists($controller, $method)) {
                        self::terminate();
                    }

                    return call_user_func_array([$controller, $method], $parameters);

                } catch(\Exception $e) {
                    echo $e->getMessage();
                    self::terminate();
                }

            }
        }

        return self::terminate();
    }

    private static function terminate()
    {
        echo '404 Not Found.';
        exit();
    }

}