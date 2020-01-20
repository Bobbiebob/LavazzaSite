<?php
namespace Application\Helpers;
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 11:46
 */


class View
{
    public static function get($key, $params = [])
    {
        if (!self::exists($key))
            return '404 Not Found.';

        if (!is_array($params))
            $params = [];
        // inject validation messages
        if (!isset($errors) || !isset($success)) {
            if (Session::get('error')) {
                $error = Session::get('error');
                Session::destroy('error');
            }
            if (Session::get('success')) {
                $success = Session::get('success');
                Session::destroy('success');
            }
        }
        if (is_array(Session::get('input'))) {
            $input = Session::get('input');
            Session::destroy('input');
        }
        extract($params);
        require self::filePath($key);
    }

    public static function exists($key)
    {
        return file_exists(self::filePath($key));
    }

    private static function filePath($key)
    {
        return APPDIR . 'Views' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $key) . '.php';
    }
}