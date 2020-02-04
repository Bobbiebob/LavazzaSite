<?php


namespace Application\Controllers;

use Application\Helpers\Parser;

class ParserController
{
    public function getView($station, $lines){
        $fileLocation = '/var/nfs/cloudstorage/' .$station;
        (Parser::readString($fileLocation, $lines));
    }
}