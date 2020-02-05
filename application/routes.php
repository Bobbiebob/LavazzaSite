<?php
/**
 * Created by PhpStorm.
 * User: Rick and Allard
 * Date: 16-1-20
 * Time: 11:01
 */

use Application\Routing\Route;

Route::get('', 'AuthController@getIndex');
Route::post('', 'AuthController@postAuthenticate');
Route::get('logout', 'AuthController@getLogout');

Route::get('dashboard', 'DashboardController@getIndex');

Route::get('dashboard/europe', 'DashboardController@getEurope');
Route::get('dashboard/colombia', 'DashboardController@getColombia');
Route::get('dashboard/map', 'DashboardController@getMap');

Route::get('api/graph/{station}/{key}', 'APIController@getGraphData');

Route::get('api/all_current_data', 'APIController@getCurrentData');
Route::get('api/all_data/{station}', 'APIController@getAllData');

Route::get('exporter/select', 'ExportController@getSelect');
Route::post('exporter/download', 'ExportController@postDownload');

Route::get('account', 'AccountController@getForm');
Route::post('account/save', 'AccountController@postSave');
Route::post('account/password', 'AccountController@postPassword');