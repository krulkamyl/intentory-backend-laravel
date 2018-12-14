<?php

//use Illuminate\Http\Request;

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

/**
 * Customer
 */
Route::get('/customer', 'CustomerController@index')->name('backend.customer.index');
Route::get('/customer/{id}', 'CustomerController@customer')->name('backend.customer.get');
Route::post('/customer', 'CustomerController@store')->name('backend.customer.store');
Route::put('/customer/{id}', 'CustomerController@update')->name('backend.customer.update');
Route::delete('/customer/{id}','CustomerController@destroy')->name('backend.customer.destroy');

/**
 * Parameter
 */
Route::get('/parameter', 'ParameterController@index')->name('backend.parameter.index');
Route::get('/parameter/{id}', 'ParameterController@parameter')->name('backend.parameter.get');
Route::post('/parameter', 'ParameterController@store')->name('backend.parameter.store');
Route::put('/parameter/{id}', 'ParameterController@update')->name('backend.parameter.update');
Route::delete('/parameter/{id}','ParameterController@destroy')->name('backend.parameter.destroy');

/**
 * Product
 */
Route::get('/product', 'ProductController@index')->name('backend.product.index');
Route::post('/product/search', 'ProductController@search')->name('backend.product.search');
Route::get('/product/{id}', 'ProductController@product')->name('backend.product.get');
Route::get('/product/{id}/history', 'ProductController@history')->name('backend.product.history');
Route::post('/product', 'ProductController@store')->name('backend.product.store');
Route::put('/product/{id}', 'ProductController@update')->name('backend.product.update');
Route::delete('/product/{id}','ProductController@destroy')->name('backend.product.destroy');

/**
 * Rent
 */
Route::get('/rent', 'RentController@index')->name('backend.rent.index');
Route::get('/rent/{id}', 'RentController@rent')->name('backend.rent.get');
Route::post('/rent', 'RentController@store')->name('backend.rent.store');
Route::put('/rent/{id}', 'RentController@update')->name('backend.rent.update');
Route::delete('/rent/{id}','RentController@destroy')->name('backend.rent.destroy');
Route::put('/rent/{id}/rented', 'RentController@updateIsRented')->name('backend.rent.update.rented');
Route::put('/rent/{id}/denuncation', 'RentController@updateIsDenuncation')->name('backend.rent.update.denuncation');