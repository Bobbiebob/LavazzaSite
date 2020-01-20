<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 10:38
 */

namespace Application\Controllers;


use Application\Helpers\Auth;
use Application\Helpers\Redirect;
use Application\Helpers\Session;
use Application\Helpers\Validator;

class BaseController
{

    public function validate($input, $rules, $friendly = [])
    {
        $validator = Validator::make($input, $rules, $friendly);

        if (!$validator->isValid()) {

            $result = '<ul>';
            foreach ($validator->getMessageBag() as $message) {
                $result .= '<li>' . $message . '</li>';
            }
            $result .= '</ul>';
            Session::set('error', $result);
            Session::set('input', $input);

            Redirect::back();
        }
        // if we have reached it up here, we are good =]
    }

    public function requireAuth() {
        if( ! Auth::check()) {
            Redirect::to('/');
        }
    }

}