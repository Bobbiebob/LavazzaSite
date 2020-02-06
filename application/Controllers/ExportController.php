<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 29-1-20
 * Time: 10:25
 */

namespace Application\Controllers;


use Application\Helpers\Config;
use Application\Helpers\DB;
use Application\Helpers\Parser;
use Application\Helpers\View;
use SimpleXMLElement;

class ExportController extends BaseController
{

    public function getSelect() {
        return View::get('export.select');
    }

    public function postDownload() {

	$stationId = $_POST['station'];

	if(!is_numeric($_POST['timespan'])) {
		echo 'Invalid timespan. Nice try..';
		exit();
	}
	$timespan = $_POST['timespan'];
        if(!file_exists(Config::get('parser.path').$stationId)) {
                echo 'There is no data available for this station..';
                exit();
        }

        $xml = new SimpleXMLElement('<xml/>');

        /* Retrieve details on specific station, and add it to XML */
        $db = new DB();
        $query = $db->select()
            ->table('stations')
            ->where('stn', '=', $stationId)
            ->run();

        $stationData = $query->fetch();
        $station = $xml->addChild('station');
        $station->addChild('id', $stationData['stn']);
        $station->addChild('name', $stationData['name']);
        $station->addChild('country', $stationData['country']);
        $station->addChild('latitude', $stationData['latitude']);
        $station->addChild('longitude', $stationData['longitude']);
        $station->addChild('elevation', $stationData['elevation']);

        $dataset = Parser::readString(Config::get('parser.path').$stationId, $timespan);

        $measurements = $xml->addChild('measurements');
        foreach($dataset as $data) {
            $measurement = $measurements->addChild('measurement');
            $measurement->addChild('timestamp', ($data->timestamp()));
            $measurement->addChild('temperature', $data->getTemperature());
            $measurement->addChild('dew_point', $data->getDewpoint());
            $measurement->addChild('air_pressure_land', $data->getAirPressureLand());
            $measurement->addChild('air_pressure_sea', $data->getAirPressureSea());
            $measurement->addChild('visibility', $data->getVisibility());
            $measurement->addChild('windspeed', $data->getWindspeed());
            $measurement->addChild('rainfall', $data->getRainfall());
            $measurement->addChild('snowfall', $data->getSnowfall());
            $measurement->addChild('cloud_cover',  $data->getCloudCover());
            $measurement->addChild('wind_direction', $data->getWindDirection());
        }

        header('Content-disposition: attachment; filename=export-' . $stationId . '.xml');
        header('Content-type: text/xml');
        return $xml->asXML();
    }

}
