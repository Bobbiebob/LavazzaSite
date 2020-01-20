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

Route::get('view/{param}', 'AuthController@getView');