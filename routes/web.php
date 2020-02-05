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
Route::get('/addform','VolokController@addform')->name('addform');
Route::post('/add','VolokController@add');
Route::get('/view_helpers','VolokController@view_helpers')->name('view_helpers');
Route::get('/del_helpers','VolokController@del_helpers')->name('del_helpers');
Route::get('/edit_helpers','VolokController@edit_helpers')->name('edit_helpers');
Route::post('/update_helpers','VolokController@update_helpers')->name('update_helpers');
Route::post('/add_helpers','VolokController@add_helpers')->name('add_helpers');
Route::get('/addform_ticket','TicketController@addform')->name('addform_ticket');
Route::post('/add_ticket','TicketController@add')->name('add_ticket');
Route::get('/view_ticket','TicketController@view')->name('view_ticket');
Route::get('/list_ticket','TicketController@list')->name('list_ticket');
Route::post('/mark_unread_ticket','TicketController@mark_unread')->name('mark_unread_ticket');
Route::post('/add_ticket_comment','TicketController@add_comment')->name('add_ticket_comment');
Route::get('/list_teh_ticket','TicketController@teh_list')->name('list_teh_ticket');
Route::get('/teh_view','VolokController@teh_view')->name('teh_view');
Route::get('/accept_teh_ticket','TicketController@accept_teh_ticket')->name('accept_teh_ticket');
Route::post('/update_teh_ticket','TicketController@update_teh_ticket')->name('update_teh_ticket');
Route::get('/edit_teh_ticket','TicketController@edit_teh')->name('edit_teh_ticket');
Route::get('/print_zakaz_narjad','TicketController@print_zakaz_narjad')->name('print_zakaz_narjad');
Route::get('/send_sms_for_pribor_form','TicketController@send_sms_for_pribor_form')->name('send_sms_for_pribor_form');



