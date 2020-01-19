<?php
namespace Application\Controllers;
use App\Helpers\View;

/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 10:55
 */

class AuthController
{

    public function getIndex() {
        return View::get('auth.index');
    }

    public function getView($param) {
        return $param;
    }

}