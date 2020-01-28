<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 11:11
 */

namespace Application\Controllers;


use Application\Helpers\Auth;
use Application\Helpers\Redirect;
use Application\Helpers\View;

class DashboardController extends BaseController
{

    public function __construct()
    {
        $this->requireAuth();
    }

    public function getIndex() {
//        echo 'Welcome, ' . Auth::user()['first_name'] . ' ' . Auth::user()['last_name'] . '!<br />';
//        return 'You are logged in! <a href="/logout">Click here to log out</a>';
//        return View::get('Dashboard.dashboardChartJS');
        Redirect::to('/dashboard/europe');
    }

    public function getEurope() {
        return View::get('Dashboard.dashboardChartJS');
    }
    public function getMap() {
        return View::get('Dashboard.map');
    }

}