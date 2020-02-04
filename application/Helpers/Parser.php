<?php


namespace Application\Helpers;



use Application\Models\Measurement;

class Parser
{
    public function __construct(){
    }

//    private static function read_file($file, $lines)
//    {
//        $handle = fopen($file, "r");
//
////        $linecount = 0;
////        while(!feof($handle)){
////            $line = fgets($handle, 500);
////            $linecount++;
////        }
////        if($linecount < $lines){
////            $lineCounter = $linecount;
////        }
////        else $lineCounter = $lines;
//        $lineCounter = $lines;
//
//        $pos = -2;
//        $beginning = false;
//        $text = array();
//        while ($lineCounter > 0) {
//            $t = " ";
//            while ($t != "\n") {
//                if (fseek($handle, $pos, SEEK_END) == -1) {
//                    $beginning = true;
//                    break;
//                }
//                $t = fgetc($handle);
//                $pos--;
//            }
//            $lineCounter--;
//            if ($beginning) {
//                rewind($handle);
//            }
//            $text[$lines - $lineCounter - 1] = fgets($handle);
//            if ($beginning) break;
//        }
//        fclose($handle);
//        return array_reverse($text);
//
//
//}

     private static function read_file($filename, $lines, $buffer = 4096)
     {
         // Open the file
         $f = fopen($filename, "rb");

         // Jump to last character
         fseek($f, -1, SEEK_END);

         // Read it and adjust line number if necessary
         // (Otherwise the result would be wrong if file doesn't end with a blank line)
         if(fread($f, 1) != "\n") $lines -= 1;

         // Start reading
         $output = '';
         $chunk = '';

         // While we would like more
         while(ftell($f) > 0 && $lines >= 0)
         {
             // Figure out how far back we should jump
             $seek = min(ftell($f), $buffer);

             // Do the jump (backwards, relative to where we are)
             fseek($f, -$seek, SEEK_CUR);

             // Read a chunk and prepend it to our output
             $output = ($chunk = fread($f, $seek)).$output;

             // Jump back to where we started reading
             fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);

             // Decrease our line counter
             $lines -= substr_count($chunk, "\n");
         }

         // While we have too many lines
         // (Because of buffer size we might have read too many)
         while($lines++ < 0)
         {
             // Find first newline and remove all text before that
             $output = substr($output, strpos($output, "\n") + 1);
         }

         // Close file and return
         fclose($f);
         return $output;
     }

    public static function readString($fileLocation, $linesAmount)
    {
        if(file_exists($fileLocation)){
            $measurementArray = [];

            $lines = self::read_file($fileLocation, $linesAmount);
            foreach ($lines as $line) {
                $date = bindec(substr($line, 0, 5));
                $time = bindec(substr($line, 5, 18));
                if (strlen($time) < 8) {
                    $time = "0" . $time;
                }
                $time = substr($time, 0, 2) . "-" . substr($time, 2, 2) . "-" . substr($time, 4, 2);
                $dateTime = $date . "-" . $time;
                $dateTime = date_create_from_format("j-H-i-s", $dateTime);
                $temperature = round(bindec(substr($line, 23, 11)) / 10 - 99.9, 2);
                $dewPoint = round(bindec(substr($line, 34, 11)) / 10 - 99.9, 2);
                $landPres = bindec(substr($line, 45, 12)) / 10 + 700;
                $seaPres = bindec(substr($line, 57, 12)) / 10 + 700;
                $visibility = bindec(substr($line, 69, 10)) / 10;
                $windSpeed = bindec(substr($line, 79, 4));
                $rainfall = bindec(substr($line, 83, 17)) / 100;
                $snowfall = bindec(substr($line, 100, 14)) / 10;
                $froze = boolval(substr($line, 114, 1));
                $rain = boolval(substr($line, 115, 1));
                $snow = boolval(substr($line, 116, 1));
                $hail = boolval(substr($line, 117, 1));
                $thunder = boolval(substr($line, 118, 1));
                $tornado = boolval(substr($line, 119, 1));
                $clouds = bindec(substr($line, 120, 7));
                $windDirection = substr($line, 127, 3);

                switch ($windDirection) {
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


        return [Measurement::getDummy()];


    }

}