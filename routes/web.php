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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'CustomersController@customer');
Route::get('/customer', 'CustomersController@index');
Route::post('/storedata', 'CustomersController@storeCustomer');
Route::post('/services', 'CustomersController@services');
Route::post('/customer/destroy/{id}', 'CustomersController@destroy');
Route::get('/services/destroy/{id}', 'CustomersController@servicesDestroy');

Route::get('/leads', 'CustomersController@leads');
Route::post('/lead/destroy/{id}', 'CustomersController@leadDestory');
Route::get('/lead/edit/{id}', 'CustomersController@editLead');
Route::post('/lead/update_lead_data/{id}', 'CustomersController@update_lead_data');
Route::get('/sale/edit/{id}', 'CustomersController@editSales');
Route::post('/sale/load_services/{id}', 'CustomersController@load_services');
Route::post('/sale/update_sale_data/{id}', 'CustomersController@update_sale_data');


Route::get('/users', 'UsersController@index');
Route::get('/users/create', 'UsersController@create');
Route::post('/users/store', 'UsersController@store');
Route::get('/users/edit/{id}', 'UsersController@edit');
Route::post('/users/update/{id}', 'UsersController@update');
Route::post('/users/destroy/{id}', 'UsersController@destroy');
Route::get('/users/center/{id}', 'UsersController@center');
Route::post('/users/update_center/{id}', 'UsersController@update_center');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
