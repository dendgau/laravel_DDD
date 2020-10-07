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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function() {
    Route::post('login', 'APIAuthController@login')->name('api_auth_login');
    Route::post('register', 'APIAuthController@register')->name('api_auth_register');
    Route::post('logout', 'APIAuthController@logout')->name('api_auth_logout');
    Route::post('refresh', 'APIAuthController@refresh')->name('api_auth_refresh');
    Route::get('profile', 'APIAuthController@profile')->name('api_auth_profile');
});
