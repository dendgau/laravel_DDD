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

Route::get('/test/index', 'TestingController@index')->name('index_test');
Route::get('/test/log', 'TestingController@log')->name('log_test');
Route::get('/test/createBlog', 'TestingController@createBlog')->name('create_blog');
Route::get('/test/getBlog', 'TestingController@getBlog')->name('get_blog');
