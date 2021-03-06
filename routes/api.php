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
    'prefix' => 'api'
], function() {
    Route::group([
        'prefix' => 'auth'
    ], function() {
        Route::post('login', 'Api\AuthController@login')->name('api_login');
        Route::post('register', 'Api\AuthController@register')->name('api_register');
        Route::post('logout', 'Api\AuthController@logout')->name('api_logout');
        Route::post('refresh', 'Api\AuthController@refresh')->name('api_refresh');
        Route::get('profile', 'Api\AuthController@profile')->name('api_profile');
    });
});
Route::get('api/ebay/inquireTest', 'Api\EbayController@testInquire')->name('api_ebay_sdk_test_inquire');
Route::get('api/ebay/sdkTest', 'Api\EbayController@testSDK')->name('api_ebay_sdk_test');
Route::get('api/ebay/simpleTest', 'Api\EbayController@testSimple')->name('api_ebay_simple_test');
