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
  Test Databaase Connection
  try {
  DB::connection()->getPdo();
  } catch (\Exception $e) {
  die("Could not connect to the database.  Please check your configuration.");
  }
 *  */
Route::resource('hotel', 'HotelController');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('list_hotel', 'HotelController@create');



