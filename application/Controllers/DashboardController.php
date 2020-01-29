<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 11:11
 */

namespace Application\Controllers;


use Application\Helpers\Auth;
use Application\Helpers\DB;
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

        $db = new DB;
        $query = $db->select()
            ->table('stations');
        $db->whereOperator(DB::OR);

        $db->where('stn', '=', '10080');
        /*
         *     cy: 459;
    cx: 255;
         */
        $db->where('stn', '=', '160590');
        $db->where('stn', '=', '103130');
        $db->where('stn', '=', '156091');

        $db->where('stn', '=', '80001');
        $db->where('stn', '=', '85600');

//        $db->where('stn', '=', '85750');

        $db->run();
        $stations = $db->fetchAll();

        return View::get('Dashboard.map', ['stations' => $stations]);
    }

}