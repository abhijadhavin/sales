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
Route::get('/sale/edit/{id}', 'CustomersController@editSales');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
