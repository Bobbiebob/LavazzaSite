<?php
session_start();

use \Application\Routing\Router;

//error_reporting(0);
//ini_set('display_errors', '0');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

define('START_TIME', microtime(true));
define('BASEDIR', __DIR__ . DIRECTORY_SEPARATOR);
define('APPDIR', BASEDIR . 'application' . DIRECTORY_SEPARATOR);
define('CONFIGDIR', BASEDIR . 'config' . DIRECTORY_SEPARATOR);

$GLOBALS['routes'] = [
    'GET' => [],
    'POST' => []
];

require_once 'application/autoload.php';
require_once 'application/routes.php';


echo Router::dispatch();