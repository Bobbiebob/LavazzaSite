<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 28-1-20
 * Time: 10:34
 */

namespace Application\Controllers;

use Application\Helpers\DB;
use Application\Helpers\Parser;

class APIController extends BaseController
{

    public function getGraphData($station, $key)
    {

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

        $db->where('country', '=', 'COLOMBIA');

        $query->run();

        $data = [];

        $fake = 0;

        foreach($query->fetchAll() as $station) {
            $countries[] = $station['country'];
            // TODO: fetch real data based on station in question
            $measurement = Parser::readString($station, 1);
            $measurement = $measurement[0];

            $listSVG = "";
            if($measurement->getTornado()){
                $listSVG .= '<img src="\assets\images\Tornado.svg" height="30px" title="There has been a tornado"/> &nbsp;' ;
            }
            if($measurement->getThunder()){
                $listSVG .= '<img src="\assets\images\Thunder.svg" height="30px" title="There has been thunderclouds"/> &nbsp;';
            }
            if($measurement->getHail()){
                $listSVG .= '<img src="\assets\images\Hail.svg" height="30px" title="There has been hailclouds"/> &nbsp;';
            }
            if($measurement->getRain()){
                $listSVG .= '<img src="\assets\images\Rain.svg" height="30px" title="There has been rainclouds"/> &nbsp;';
            }
            if($measurement->getSnow()){
                $listSVG .= '<img src="\assets\images\Snowstorm.svg" height="30px" title="There has been snowclouds"/> &nbsp;';
            }
            if($measurement->getFroze()){
                $listSVG .= '<img src="\assets\images\Freezing.svg" height="30px" title="It has frozen"/> &nbsp;';
            }

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
                '<span style="white-space:nowrap">' . $listSVG . '</span>'
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