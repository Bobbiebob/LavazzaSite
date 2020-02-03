<?php


namespace Application\Controllers;

use Application\Helpers\Parser;

class ParserController
{
    public function getView(){
        (Parser::readString());
    }
}