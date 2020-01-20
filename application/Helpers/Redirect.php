<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 10:36
 */

namespace Application\Helpers;


class Redirect
{

    public static function to($url)
    {
        header('Location: ' . $url);
        exit();
    }

    public static function back()
    {
        self::to(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/');
    }

}