<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 11:47
 */

namespace App\Helpers;


class Session
{

    public static function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];

        return false;
    }

    public static function destroy($key)
    {
        unset($_SESSION[$key]);
        return true;
    }

}