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

Route::post('/','VolokController@index')->middleware('can:check_rights,"view_clients"');
Route::get('/','VolokController@index')->middleware('can:check_rights,"view_clients"')->name('volok');
Route::get('/edit','VolokController@editform')->middleware('can:check_rights,"edit_clients"')->name('edit');
Route::post('/update','VolokController@update')->middleware('can:check_rights,"edit_clients"')->name('update');
Route::get('/view','VolokController@view')->middleware('can:check_rights,"view_clients"')->name('view');
Route::get('/addform','VolokController@addform')->middleware('can:check_rights,"view_clients"')->name('addform');
Route::post('/add','VolokController@add')->middleware('can:check_rights,"view_clients"');

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
Route::get('/sms_history_for_pribor','TicketController@sms_history_for_pribor')->name('sms_history_for_pribor');
Route::get('/send_sms_for_pribor','TicketController@send_sms_for_pribor')->name('send_sms_for_pribor');



Route::get('/auth/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/auth/login', 'Auth\LoginController@login');
Route::get('/auth/logout', 'Auth\LoginController@logout')->name('logout');
Route::view('/auth/print_menu','auth/print_menu')->middleware('can:user_manager')->name('/auth/print_menu');
Route::get('/auth/create_form','Auth\RegisterController@showRegistrationForm')->middleware('can:user_manager')->name('/auth/create_form');
Route::post('/auth/register', 'Auth\RegisterController@register')->middleware('can:user_manager')->name('register');
Route::get('/auth/add_permissions_form', 'Auth\AuthController@add_permissions_form')->middleware('can:user_manager')->name('/auth/add_permissions_form');
Route::post('/auth/add_permissions', 'Auth\AuthController@add_permissions')->middleware('can:user_manager')->name('/auth/add_permissions');
Route::get('/auth/add_role_form', 'Auth\AuthController@add_role_form')->middleware('can:user_manager')->name('/auth/add_role_form');
Route::post('/auth/add_role', 'Auth\AuthController@add_role')->middleware('can:user_manager')->name('/auth/add_role');