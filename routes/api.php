<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api', 
    'prefix' => 'auth'
], function() {
    Route::post('login', 'Api\AuthController@login')->name('api_login');
    Route::post('register', 'Api\AuthController@register')->name('api_register');
    Route::post('logout', 'Api\AuthController@logout')->name('api_logout');
    Route::post('refresh', 'Api\AuthController@refresh')->name('api_refresh');
    Route::get('profile', 'Api\AuthController@profile')->name('api_profile');
});
