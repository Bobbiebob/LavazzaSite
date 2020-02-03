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

        $points = [
            // Norway
            10260, // Trondo
            13840, // Oslo
            13170, // Bergen
            11520,// bodo
            12710, // Trondheim
            12230, // Kristiansund
            11220, // Mosjoen
            13100, // Floro
            14520, // Kristiandand
            14150, // Stavanger
            14825, // Torp

            // Sweden
            24640, // Stockholm
            20730, // Karlstad
            21860, // Lulea
            20660, // Sundsvall,
            20440, // Kiruna
            22260, // Ostersund
            21190, // Umea
            20130, // RItsem
            20240, // Stora
            25130, // goteborg
            26110, // Helsingborg
            26720, // Kalmar
            20580, // Harapanda
            22300, // Gubbhogen
            23160, // Sarna
            24350, // Borlange
            25920, // Olands
            20900, // Visby
            20870, // Jonkoping
            26350, // Malmo

            // Denmark
            60300, // Aalborg
            60120, // Fugloy
            60740, // Aarhus
            61040, // Billund
            61800, // Koebenhaven
            60890, // Seadenstrnad
            60240, // Thisted
            61200, // Odense
            60800, // Esbjerg

            // Netherlands
            62790, // Hoogeveen
            62800, // Groningen
            63440, // Rotterdam
            62400, // Amsterdam
            62900, // Twente
            62750, // Deelden
            62600, // De bilt
            63250, // Zierikzee
            63750, // volkel
            63700, // eindhoven

            // BElgium
            63700, // Oostende
            64500, // Antwerp
            64310, // Gent
            64000, // Koksijde,
            64510, // Bruxelles,
            64785, // Liege,
            64960, // Elsenborn
            64780, // bierset
            64490, // Charleroi
            64900, // Spa
            64760, // St Hubert

            // LUX
            64785,
            65900,

            // Switzerland

            66200, // SCHAFFHAUSEN
            66700, // ZURICH-KLOTEN
            66600, // ZUERICH METEOSCHWEI
            66621, // GRENCHEN
            66300, // BERN-BELP
            66100, // PAYERNE
            66304, // SAMEDAN
            67000, // GENEVE-COINTRIN
            67200, // SION
        ];

//        foreach($points as $point) {
//            $db->where('stn', '=', $point);
//        }
//
//        /* Countries having relatively few monitors, so manual sampling is not required */
//        $db->where('country', '=', 'ESTONIA');
//        $db->where('country', '=', 'LATVIA');
//        $db->where('country', '=', 'LITHUANIA');
//        $db->where('country', '=', 'BELARUS');
//        $db->where('country', '=', 'MOLDOVA');
//        $db->where('country', '=', 'BULGARIA');
//        $db->where('country', '=', 'CROATIA');
//        $db->where('country', '=', 'POLAND');
//
//        $db->where('country', '=', 'NORWAY');
//        $db->where('country', '=', 'SWEDEN');
//        $db->where('country', '=', 'FINLAND');
//
//        $db->where('country', '=', 'UKRAINE');
//        $db->where('country', '=', 'ROMANIA');
//        $db->where('country', '=', 'HUNGARY');
//        $db->where('country', '=', 'SLOVENIA');
//
//        $db->where('country', '=', 'AUSTRIA');
//        $db->where('country', '=', 'CZECH REPUBLIC');
//        $db->where('country', '=', 'GERMANY');
//
//        $db->where('country', '=', 'FRANCE');
//        $db->where('country', '=', 'SPAIN');
//
//        $db->where('stn', '=', '10080');
//        $db->where('stn', '=', '160590');
//        $db->where('stn', '=', '103130');
//        $db->where('stn', '=', '156091');
//
//        $db->where('stn', '=', '80001');
//        $db->where('stn', '=', '85600');

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