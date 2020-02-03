<?php
namespace Application\Models;
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 30-1-20
 * Time: 12:43
 */

class Measurement
{

    private $timestamp;
    private $temperature;
    private $dew_point;
    private $air_pressure_land;
    private $air_pressure_sea;
    private $visibility;
    private $windspeed;
    private $rainfall;
    private $snowfall;
    private $cloud_cover;
    private $wind_direction;

    private $froze;
    private $rain;
    private $snow;
    private $hail;
    private $thunder;
    private $tornado;

    public static function getDummy($time = null) {
        $object = new Measurement();

        if(is_null($time)) {
            // Set time to current if not set.
            $time = time();
        }

        $object->setTimestamp($time);
        $object->setTemperature((float) 19.3);
        $object->setDewPoint((float) 5.6);
        $object->setAirPressureLand((int) 100);
        $object->setAirPressureSea((int) 50);
        $object->setVisibility((int) 5);
        $object->setWindspeed((int) 100);
        $object->setRainfall((int) 5);
        $object->setSnowfall((int) 0);
        $object->setCloudCover('CLOUDY');
        $object->setWindDirection('NW');
        $object->setTornado(false);
        $object->setThunder(false);
        $object->setHail(false);
        $object->setSnow(false);
        $object->setRain(false);
        $object->setFroze(false);

        return $object;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return mixed
     */
    public function getDewPoint()
    {
        return $this->dew_point;
    }

    /**
     * @param mixed $dew_point
     */
    public function setDewPoint($dew_point)
    {
        $this->dew_point = $dew_point;
    }

    /**
     * @return mixed
     */
    public function getAirPressureLand()
    {
        return $this->air_pressure_land;
    }

    /**
     * @param mixed $air_pressure_land
     */
    public function setAirPressureLand($air_pressure_land)
    {
        $this->air_pressure_land = $air_pressure_land;
    }

    /**
     * @return mixed
     */
    public function getAirPressureSea()
    {
        return $this->air_pressure_sea;
    }

    /**
     * @param mixed $air_pressure_sea
     */
    public function setAirPressureSea($air_pressure_sea)
    {
        $this->air_pressure_sea = $air_pressure_sea;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getWindspeed()
    {
        return $this->windspeed;
    }

    /**
     * @param mixed $windspeed
     */
    public function setWindspeed($windspeed)
    {
        $this->windspeed = $windspeed;
    }

    /**
     * @return mixed
     */
    public function getRainfall()
    {
        return $this->rainfall;
    }

    /**
     * @param mixed $rainfall
     */
    public function setRainfall($rainfall)
    {
        $this->rainfall = $rainfall;
    }

    /**
     * @return mixed
     */
    public function getSnowfall()
    {
        return $this->snowfall;
    }

    /**
     * @param mixed $snowfall
     */
    public function setSnowfall($snowfall)
    {
        $this->snowfall = $snowfall;
    }

    /**
     * @return mixed
     */
    public function getCloudCover()
    {
        return $this->cloud_cover;
    }

    /**
     * @param mixed $cloud_cover
     */
    public function setCloudCover($cloud_cover)
    {
        $this->cloud_cover = $cloud_cover;
    }

    /**
     * @return mixed
     */
    public function getWindDirection()
    {
        return $this->wind_direction;
    }

    /**
     * @param mixed $wind_direction
     */
    public function setWindDirection($wind_direction)
    {
        $this->wind_direction = $wind_direction;
    }


    /**
     * @return mixed
     */
    public function getFroze()
    {
        return $this->froze;
    }

    /**
     * @param mixed $froze
     */
    public function setFroze($froze)
    {
        $this->froze = $froze;
    }

    /**
     * @return mixed
     */
    public function getTornado()
    {
        return $this->tornado;
    }

    /**
     * @param mixed $tornado
     */
    public function setTornado($tornado)
    {
        $this->tornado = $tornado;
    }


    /**
     * @return mixed
     */
    public function getRain()
    {
        return $this->rain;
    }

    /**
     * @param mixed $rain
     */
    public function setRain($rain)
    {
        $this->rain = $rain;
    }

    /**
     * @return mixed
     */
    public function getSnow()
    {
        return $this->snow;
    }

    /**
     * @param mixed $snow
     */
    public function setSnow($snow)
    {
        $this->snow = $snow;
    }

    /**
     * @return mixed
     */
    public function getHail()
    {
        return $this->hail;
    }

    /**
     * @param mixed $hail
     */
    public function setHail($hail)
    {
        $this->hail = $hail;
    }

    /**
     * @return mixed
     */
    public function getThunder()
    {
        return $this->thunder;
    }

    /**
     * @param mixed $thunder
     */
    public function setThunder($thunder)
    {
        $this->thunder = $thunder;
    }
}