<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 11:01
 */

use Application\Routing\Route;

Route::get('', 'AuthController@getIndex');
Route::get('view/{param}', 'AuthController@getView');