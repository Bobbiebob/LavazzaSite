<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 10:29
 */

namespace Application\Helpers;

class Config
{
    // variable that will act as a cache for config values.
    private static $config = [];

    /**
     * get()
     * This function will return a certain value if it is set.
     *
     * @param $key String in the following form: 'database.host' to load config/database.php and read the 'host' from the parent array.
     * @return string, array or bool - bool only if there is no value for the requested key. With multidimensional arrays,
     * the function can return those as a whole.
     */
    public static function get($key)
    {
        // split the key into pieces (by dividing at the dots)
        $parts = explode('.', $key);
        // use the first part of the key to determine the file to use.
        $file = array_shift($parts);
        if (!isset(self::$config[$file])) {
            // settings have not been cached yet, inject from config/$file.php if it exists.
            $path = CONFIGDIR . $file . '.php';
            if (file_exists($path)) {
                self::$config[$file] = require $path;
            }
        }
        $config = self::$config[$file];
        // loop through the parts which determine the setting
        foreach ($parts as $part) {
            // if we have reached an array, and we have not had all parts of the key, keep digging.
            if (isset($config[$part]) && is_array($config[$part]) && end($parts) !== $part) {
                $config = $config[$part];
            }
            // if this is the final piece of the key and it is existant: return the value : done :)
            if (isset($config[$part]) && end($parts) == $part) {
                return $config[$part];
            }
        }
        return false;
    }

}
