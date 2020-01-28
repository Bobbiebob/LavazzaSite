<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 16-1-20
 * Time: 11:01
 */

use Application\Routing\Route;

Route::get('', 'AuthController@getIndex');
Route::post('', 'AuthController@postAuthenticate');
Route::get('logout', 'AuthController@getLogout');

Route::get('dashboard', 'DashboardController@getIndex');

Route::get('api/graph/{station}/{key}', 'APIController@getGraphData');

Route::get('api/all_data/{station}', 'APIController@getAllData');

Route::get('view/{param}', 'AuthController@getView');