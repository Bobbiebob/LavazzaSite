<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 10:28
 */
namespace Application\Helpers;

class Auth
{

    protected $hashed = ['password'];
    public static $checkHash = [];

    public static function attempt($data)
    {

        if(isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        var_dump($data);

        $db = new DB();
        $query = $db->select()
            ->table('users');
        foreach ($data as $key => $value) {
            if (in_array($key, self::object()->hashed)) {
                // DO NOT add to Query, but fetch later and check using password_verify()
                self::$checkHash[$key] = $value;
            } else {
                // add to Query
                $query = $query->where($key, $value);
            }
        }
        $query->run();
        if ($query->count() !== 1) {
            return false;
        }
        $data = $query->fetch();
        foreach (self::$checkHash as $key => $value) {
            if (!isset($data[$key]))
                return false;
            if (!self::verify($value, $data[$key]))
                return false;
        }

        return Session::set('auth', $data['id']);
    }

    public static function check()
    {
        if (Session::get('auth'))
            return true;

        return false;
    }

    public static function logout()
    {
        if (self::check())
            Session::destroy('auth');

        return true;
    }

    public static function user()
    {
        if (!self::check())
            return false;

        $db = new DB;
        $query = $db->select()
            ->table('users')
            ->where('id', self::id());

        $query->run();
        if ($query->count() == 1)
            return $query->fetch();

        return [];
    }

    public static function id()
    {
        if (self::check())
            return Session::get('auth');

        return NULL;
    }

    public static function verify($input, $hash)
    {
        return password_verify($input, $hash);
    }

    public static function hash($input)
    {
        return password_hash($input, PASSWORD_ARGON2I);
    }

    public static function object()
    {
        $auth = new Auth;
        return $auth;
    }

}