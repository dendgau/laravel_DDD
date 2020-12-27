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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'test'
], function() {
    Route::get('index', 'Web\TestingController@index')->name('test_index');
    Route::get('log', 'Web\TestingController@log')->name('test_log');
    
    // For blog
    Route::group([
        'prefix' => 'blog'
    ], function() {
        Route::get('create', 'Web\TestingController@createBlog')->name('blog_create');
        Route::get('get', 'Web\TestingController@getBlog')->name('blog_get');
    });
});