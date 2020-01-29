<?php
namespace Application\Controllers;
use Application\Helpers\Auth;
use Application\Helpers\Redirect;
use Application\Helpers\Session;
use Application\Helpers\View;

/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 10:55
 */

class AuthController extends BaseController
{

    public function __construct()
    {

    }

    public function redirectAuthenticated() {
        // Redirect to /dashboard if logged in
        if(Auth::check()) {
            Redirect::to('/dashboard');
        }
    }

    public function getIndex() {
        $this->redirectAuthenticated();
        return View::get('auth.index');
    }

    public function getLogout() {
        Auth::logout();
        Redirect::to('/');
    }

    public function postAuthenticate() {
        $this->redirectAuthenticated();

        if($_POST['email'] == 'password@password.it') {
            echo 'Generated: ' . Auth::hash($_POST['password']);
            exit();
        }

        // validation
        $validate = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $niceNames = [
            'password' => 'E-mail address',
            'email' => 'Password'
        ];

        $this->validate($_POST, $validate, $niceNames);

        if (Auth::attempt([
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ])) {
            $to = '/dashboard';
            if(Session::get('origin')) {
                $to = Session::get('origin');
                Session::destroy('origin');
            }
            Redirect::to($to);
        }

        Session::set('error', 'Ongeldige inloggegevens.');
        Session::set('input', $_POST);
        Redirect::to('/');
    }


}