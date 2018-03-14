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
Route::get('delete_hotel/{id}', 'HotelController@destroy');

Route::resource('restaurant', 'RestaurantsController');
Route::get('delete_restaurant/{id}', 'RestaurantsController@destroy');

Route::resource('set_menu', 'SetMenusController');
Route::get('delete_set_menu/{id}', 'SetMenusController@destroy');

Route::resource('report', 'ReportsController');

Route::group(['prefix' => 'setting'], function (){

    Route::resource('users', '\App\Http\Controllers\Setting\User\UsersController');

    //Route::get('edit_user/{id}', '\App\Http\Controllers\Setting\User\UsersController@edit');
    //Route::post('create_user', '\App\Http\Controllers\Setting\User\UsersController@store');
});



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function(){
    return view('test.index');
});










