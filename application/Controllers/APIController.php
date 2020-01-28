<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 28-1-20
 * Time: 10:34
 */

namespace Application\Controllers;


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
        $reference = time();
        foreach($datapoints as $point) {
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

    public function getAllData($station) {

        $data = [];

        foreach(array_range('1-10000') as $station) {

        }

        return json_encode(['data' => $data]);
    }

}