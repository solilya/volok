<?php

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

Route::post('/','VolokController@index');
Route::get('/','VolokController@index')->name('volok');
Route::get('/edit','VolokController@editform')->name('edit');
Route::post('/update','VolokController@update')->name('update');
Route::get('/view','VolokController@view')->name('view');