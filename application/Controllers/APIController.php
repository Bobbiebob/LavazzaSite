<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 28-1-20
 * Time: 10:34
 */

namespace Application\Controllers;

use Application\Helpers\Config;
use Application\Helpers\DB;
use Application\Helpers\Parser;

class APIController extends BaseController
{

    public function getGraphData($station, $key)
    {

        $measurements = Parser::readString(Config::get('parser.path').$station['stn'], 1000);

        $data = [];
        foreach($measurements as $measurement) {

            if ($key == 'visibility'){
                $point = $measurement->getVisibility();
            }

            if($key == 'temperature'){
                $point = $measurement->getTemperature();
            }

            if($key == 'rainfall'){
                $point = $measurement->getRainfall();
            }

            if($key == 'snowfall'){
                $point = $measurement->getSnowfall();
            }

            $data[] = [
                'x' => round($measurement->getTimestamp()->getTimestamp()),
                'y' => $point
            ];

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
            $measurement = Parser::readString(Config::get('parser.path').$station['stn'], 1);
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
                $measurement->getWindspeed() . ' km/h @ ' . $measurement->getWindDirection(),
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