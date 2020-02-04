<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 28-1-20
 * Time: 10:34
 */

namespace Application\Controllers;


use Application\Helpers\DB;
use Application\Models\Measurement;

class APIController extends BaseController
{

    public function getGraphData($station, $key)
    {
//        var_dump($station, $key);
        // string(5) "12912" string(11) "temperature"

        $datapoints = [
            -1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4
        ];

        $data = [];
        $reference = time() - 14400;
        foreach($datapoints as $point) {
            $point = 15;
            $diff = rand(1, 5);
            if(rand(0, 1) == 1) {
                $diff = $diff*-1;
            }
            $point = $point += $diff;
            $data[] = [
                'x' => round($reference),
                'y' => $point
            ];

            $reference += 60;
        }

        return json_encode(['data' => $data]);
    }

    public function getCurrentData() {
        $db = new DB();
        $query = $db->select()
            ->table('stations');


        // Only get rows for European (ish) countries :P
//        $db->whereOperator(DB::OR);
//        $db->where('country', '=', 'JAN MAYEN');
//        $db->where('country', '=', 'NORWAY');
//        $db->where('country', '=', 'SVALBARD');
//        $db->where('country', '=', 'SWEDEN');
//        $db->where('country', '=', 'FINLAND');
//        $db->where('country', '=', 'UNITED KINGDOM');
//        $db->where('country', '=', 'MAN ISLE OF');
//        $db->where('country', '=', 'GUERNSEY');
//        $db->where('country', '=', 'JERSEY');
//        $db->where('country', '=', 'IRELAND');
//        $db->where('country', '=', 'ICELAND');
//        $db->where('country', '=', 'GREENLAND');
//        $db->where('country', '=', 'FAROE ISLANDS');
//        $db->where('country', '=', 'DENMARK');
//        $db->where('country', '=', 'NETHERLANDS');
//        $db->where('country', '=', 'BELGIUM');
//        $db->where('country', '=', 'BELGIUM AND LUXEMBOURG');
//        $db->where('country', '=', 'LUXEMBOURG');
//        $db->where('country', '=', 'SWITZERLAND');
//        $db->where('country', '=', 'LIECHTENSTEIN');
//        $db->where('country', '=', 'FRANCE');
//        $db->where('country', '=', 'PORTUGAL');
//        $db->where('country', '=', 'SPAIN');
//        $db->where('country', '=', 'GIBRALTAR');
//        $db->where('country', '=', 'CAPE VERDE');
//        $db->where('country', '=', 'GERMANY');
//        $db->where('country', '=', 'AUSTRIA');
//        $db->where('country', '=', 'CZECH REPUBLIC');
//        $db->where('country', '=', 'SLOVAKIA');
//        $db->where('country', '=', 'POLAND');
//        $db->where('country', '=', 'HUNGARY');
//        $db->where('country', '=', 'SLOVENIA');
//        $db->where('country', '=', 'SERBIA AND MONTENEGRO, STATE UNION OF');
//        $db->where('country', '=', 'CROATIA');
//        $db->where('country', '=', 'YUGOSLAVIA (FORMER TERRITORY)');
//        $db->where('country', '=', 'BOSNIA AND HERZEGOVINA');
//        $db->where('country', '=', 'MACEDONIA');
//        $db->where('country', '=', 'ALBANIA');
//        $db->where('country', '=', 'ROMANIA');
//        $db->where('country', '=', 'BULGARIA');
//        $db->where('country', '=', 'ITALY');
//        $db->where('country', '=', 'MALTA');
//        $db->where('country', '=', 'GREECE');
//        $db->where('country', '=', 'TURKEY');
//        $db->where('country', '=', 'CYPRUS');
//        $db->where('country', '=', 'RUSSIA');
//        $db->where('country', '=', 'FORMER USSR (ASIA)');
//        $db->where('country', '=', 'FORMER USSR (EUROPE)');
//        $db->where('country', '=', 'ESTONIA');
//        $db->where('country', '=', 'BELARUS');
//        $db->where('country', '=', 'LATVIA');
//        $db->where('country', '=', 'LITHUANIA');
//        $db->where('country', '=', 'UKRAINE');
//        $db->where('country', '=', 'MOLDOVA');
//        $db->where('country', '=', 'ARMENIA');
//        $db->where('country', '=', 'KYRGYZSTAN');
//        $db->where('country', '=', 'GEORGIA');
//        $db->where('country', '=', 'AZERBAIJAN');
//        $db->where('country', '=', 'UZBEKISTAN');
//        $db->where('country', '=', 'TURKMENISTAN');
//        $db->where('country', '=', 'SYRIA');
//        $db->where('country', '=', 'LEBANON');
//        $db->where('country', '=', 'ISRAEL');
//        $db->where('country', '=', 'WEST BANK');
//        $db->where('country', '=', 'JORDAN');
//        $db->where('country', '=', 'SAUDI ARABIA');
//        $db->where('country', '=', 'IRAQ');
//        $db->where('country', '=', 'IRAN');
//        $db->where('country', '=', 'CANARY ISLANDS');
//        $db->where('country', '=', 'MOROCCO');
//        $db->where('country', '=', 'ANDORRA');
//
        $db->where('country', '=', 'COLOMBIA');

        $query->run();

        $data = [];

        $fake = 0;
//        if(date('m') % 2 == 0) {
//            $fake = 1337;
//        }

        foreach($query->fetchAll() as $station) {
            $countries[] = $station['country'];
            // TODO: fetch real data based on station in question
            $measurement = Measurement::getDummy();
            $row = [
                $station['country'] . ', ' . $station['name'],
                $measurement->getAirPressureLand() . ' bar',
                $measurement->getAirPressureSea() . ' bar',
                $measurement->getDewPoint() . ' °C',
                $measurement->getTemperature() . ' °C',
                $measurement->getVisibility() . ' km',
                $measurement->getWindspeed() . ' bft @ ' . $measurement->getWindDirection(),
                $measurement->getRainfall() . ' mm',
                $measurement->getSnowfall() . ' mm',
                ($measurement->getTornado() ? 'Yes' : 'No'),
                ($measurement->getHail() ? 'Yes' : 'No'),
                ($measurement->getSnow() ? 'Yes' : 'No'),
                ($measurement->getRain() ? 'Yes' : 'No'),
                ($measurement->getFroze() ? 'Yes' : 'No'),
            ];

            $data[] = $row;
        }

        return json_encode(['data' => $data]);
    }

    public function getAllData($station) {

        $data = [];

        foreach(array_range('1-10000') as $station) {

        }

        return json_encode(['data' => $data]);
    }

}