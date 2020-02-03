<?php


namespace Application\Helpers;



use Application\Models\Measurement;

class Parser
{
    public function __construct(){
    }

    private static function read_file($file, $lines)
    {
        $handle = fopen($file, "r");
        $lineCounter = $lines;
        $pos = -2;
        $beginning = false;
        $text = array();
        while ($lineCounter > 0) {
            $t = " ";
            while ($t != "\n") {
                if (fseek($handle, $pos, SEEK_END) == -1) {
                    $beginning = true;
                    break;
                }
                $t = fgetc($handle);
                $pos--;
            }
            $lineCounter--;
            if ($beginning) {
                rewind($handle);
            }
            $text[$lines - $lineCounter - 1] = fgets($handle);
            if ($beginning) break;
        }
        fclose($handle);
        return array_reverse($text);
    }

    public static function readString($fileLocation, $linesAmount)
    {
        $measurementArray = [];

        $lines = self::read_file($fileLocation, $linesAmount);
        foreach ($lines as $line) {
            $date = bindec(substr($line, 0, 5));
            $time = bindec(substr($line, 5, 18));
            if(strlen($time) < 8){
                $time = "0".$time;
            }
            $time = substr($time,0, 2)."-".substr($time, 2, 2)."-".substr($time, 4, 2);
            $dateTime = $date."-".$time;
            $dateTime = date_create_from_format("j-H-i-s", $dateTime);
            $temperature = bindec(substr($line, 23, 11)) / 10 - 99.9;
            $dewPoint = bindec(substr($line, 34, 11)) / 10 - 99.9;
            $landPres = bindec(substr($line, 45, 11)) / 10 + 900;
            $seaPres = bindec(substr($line, 56, 11)) / 10 + 900;
            $visibility = bindec(substr($line, 67, 10)) / 10;
            $windSpeed = bindec(substr($line, 77, 4));
            $rainfall = bindec(substr($line, 81, 14)) / 10;
            $snowfall = bindec(substr($line, 95, 14)) / 10;
            $froze = boolval(substr($line, 109, 1));
            $rain = boolval(substr($line, 110, 1));
            $snow = boolval(substr($line, 111, 1));
            $hail = boolval(substr($line, 112, 1));
            $thunder = boolval(substr($line, 113, 1));
            $tornado = boolval(substr($line, 114, 1));
            $clouds = bindec(substr($line, 115, 7));
            $windDirection = substr($line, 122, 3);

            switch ($windDirection){
                case "000":
                    $windDirection = "N";
                    break;
                case "001":
                    $windDirection = "E";
                    break;
                case "010":
                    $windDirection = "S";
                    break;
                case "011":
                    $windDirection = "W";
                    break;
                case "100":
                    $windDirection = "NE";
                    break;
                case "101":
                    $windDirection = "SE";
                    break;
                case "110":
                    $windDirection = "SW";
                    break;
                case "111":
                    $windDirection = "NW";
                    break;
            }

            $measurement = new Measurement();
            $measurement->setTimestamp($dateTime);
            $measurement->setTemperature($temperature);
            $measurement->setDewPoint($dewPoint);
            $measurement->setAirPressureLand($landPres);
            $measurement->setAirPressureSea($seaPres);
            $measurement->setVisibility($visibility);
            $measurement->setWindspeed($windSpeed);
            $measurement->setRainfall($rainfall);
            $measurement->setSnowfall($snowfall);
            $measurement->setFroze($froze);
            $measurement->setRain($rain);
            $measurement->setHail($hail);
            $measurement->setSnow($snow);
            $measurement->setThunder($thunder);
            $measurement->setTornado($tornado);
            $measurement->setCloudCover($clouds);
            $measurement->setWindDirection($windDirection);

            $measurementArray[] = $measurement;
        }

        return $measurementArray;
    }

}