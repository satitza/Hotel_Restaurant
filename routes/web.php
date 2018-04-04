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
Route::post('search_hotel', 'HotelController@searchHotel');
Route::get('delete_hotel/{id}', 'HotelController@destroy');

Route::resource('restaurant', 'RestaurantsController');
Route::post('search_restaurant', 'RestaurantsController@searchRestaurant');
Route::get('delete_restaurant/{id}', 'RestaurantsController@destroy');

Route::resource('offer', 'OffersController');
Route::post('search_offer', 'OffersController@SearchOffer');
Route::get('delete_offer/{id}', 'OffersController@destroy');

Route::resource('image', 'ImagesController');
//Route::get('upload', 'ImagesController@store');
//Route::post('search_offer', 'OffersController@SearchOffer');
//Route::get('delete_offer/{id}', 'OffersController@destroy');

Route::resource('report', 'ReportsController');

Route::group(['prefix' => 'setting'], function (){

    Route::resource('users', '\App\Http\Controllers\Setting\User\UsersController');
    Route::get('delete_users/{id}', '\App\Http\Controllers\Setting\User\UsersController@destroy');
    Route::post('users_update_password', '\App\Http\Controllers\Setting\User\UsersController@update_password');

    Route::group(['prefix' => 'report'], function(){
        Route::resource('users', '\App\Http\Controllers\Setting\User\ReportUsersController');
        Route::get('delete_report_users/{id}', '\App\Http\Controllers\Setting\User\ReportUsersController@destroy');
    });

    Route::group(['prefix' => 'editor'], function(){
        Route::resource('users', '\App\Http\Controllers\Setting\User\EditorUsersController');
        Route::get('users_editor/{id}/add', '\App\Http\Controllers\Setting\User\EditorUsersController@AddRestaurant');
        Route::post('users_add_restaurant/{id}', '\App\Http\Controllers\Setting\User\EditorUsersController@UpdateAddRestaurant');
        Route::get('delete_editor_users/{id}', '\App\Http\Controllers\Setting\User\EditorUsersController@destroy');
    });
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function(){
    return view('test.index');
});










