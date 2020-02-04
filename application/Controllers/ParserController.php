<?php


namespace Application\Controllers;

use Application\Helpers\Config;
use Application\Helpers\Parser;

class ParserController
{
    public function getView(){
        // full path to text file
        define("TEXT_FILE", Config::get('stationFiles.path').'station');
        // number of lines to read from the end of file
        define("LINES_COUNT", Config::get('stationFiles.lines'));
        (Parser::readString(TEXT_FILE, LINES_COUNT));
    }
}