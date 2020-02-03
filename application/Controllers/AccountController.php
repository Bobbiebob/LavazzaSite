<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 3-2-20
 * Time: 11:27
 */

namespace Application\Controllers;

use Application\Helpers\Auth;
use Application\Helpers\DB;
use Application\Helpers\Redirect;
use Application\Helpers\Session;
use Application\Helpers\View;

class AccountController extends BaseController {

    public function __construct() {
        $this->requireAuth();
    }

    public function getForm() {
        $user = Auth::user();
        return View::get('account.form', ['user' => $user]);
    }

    public function postSave()
    {

        // validation
        $validate = [
            'email' => 'required|max:255|email|unique:users,email,' . Auth::id(),
            'first_name' => 'required',
            'last_name' => 'required',
            'preferred_view' => 'required|in:europe,colombia'
//            'password' => 'required',
        ];

        $niceNames = [
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'password' => 'Password',
            'email' => 'E-mail address',
            'preferred_view' => 'Default view'
        ];

        $this->validate($_POST, $validate, $niceNames);

        $fields = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'preferred_view' => $_POST['preferred_view'],
            'email' => $_POST['email'],
        ];

        (new DB)->update($fields)->where('id', Auth::id())->table('users')->run();

        Session::set('success', 'User settings have been saved succesfully.');

        return Redirect::to('/account');
    }

    public function postPassword() {
        $validate = [
            'current_password' => 'required|max:255',
            'new_password' => 'required_with:new_password2|min:5|max:25',
            'new_password2' => 'required_with:password|match:new_password|min:5|max:25',
        ];

        $niceNames = [
            'current_password' => 'Current password',
            'new_password' => 'New password',
            'new_password2' => 'Repeat new password',
        ];

        $this->validate($_POST, $validate, $niceNames);

        if( ! Auth::verify($_POST['current_password'], Auth::user()['password'])) {
            Session::set('error', 'Your current password is incorrect.');

            return Redirect::to('/account');
        }

        $fields = [
            'password' => Auth::hash($_POST['new_password'])
        ];

        (new DB)->update($fields)->where('id', Auth::id())->table('users')->run();

        Session::set('success', 'User settings have been saved succesfully.');

        return Redirect::to('/account');
    }

}