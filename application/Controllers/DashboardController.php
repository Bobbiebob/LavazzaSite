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

        $view = Auth::user()['preferred_view'];

        Redirect::to('/dashboard/' . $view);
    }

    public function getColombia() {
        return View::get('Dashboard.colombia');
    }

    public function getEurope() {
        return View::get('Dashboard.dashboardChartJS');
    }
    public function getMap() {

        $db = new DB;
        $query = $db->select()
            ->table('stations');
        $db->whereOperator(DB::OR);


        $db->where('longitude','>', '-17.75');
        $db->where('longitude','<', '45');
        $db->where('latitude', '>', '33.567');
        $db->where('latitude', '<', '80.167');

        $db->whereOperator(DB::AND);


        $db->run();
        $stations = $db->fetchAll();

        return View::get('Dashboard.map', ['stations' => $stations]);
    }

}