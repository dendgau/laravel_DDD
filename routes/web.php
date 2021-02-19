<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// For testing
Route::group([
    'prefix' => 'test',
    'middleware' => 'auth:web'
], function() {
    Route::get('index', 'Web\TestingController@index')->name('test_index');
    Route::get('log', 'Web\TestingController@log')->name('test_log');
});

// For blog
Route::group([
    'prefix' => 'blog',
    'middleware' => 'auth:web'
], function() {
    Route::get('index', 'Web\BlogController@index')->name('blog_list');
    Route::get('{id}/show', 'Web\BlogController@show')->name('blog_show');
    Route::post('{id}/update', 'Web\BlogController@update')->name('blog_update');
    Route::post('create', 'Web\BlogController@create')->name('blog_create');
    Route::post('{id}/destroy', 'Web\BlogController@destroy')->name('blog_destroy');
});

// For auth
Route::group([
    'prefix' => 'auth',
], function() {
    Route::get('login', 'Web\LoginController@login')->name('auth_login');
    Route::post('authenticate', 'Web\LoginController@authenticate')->name('auth_authenticate');
    Route::match(['POST', 'GET'], 'logout', 'Web\LoginController@logout')->name('auth_logout');
});


