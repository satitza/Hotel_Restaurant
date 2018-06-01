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
Route::post('search_hotel', 'HotelController@searchHotel')->name('search_hotel');
Route::get('delete_hotel/{id}', 'HotelController@destroy');

Route::resource('restaurant', 'RestaurantsController');
Route::post('search_restaurant', 'RestaurantsController@searchRestaurant')->name('search_restaurant');
Route::get('delete_restaurant/{id}', 'RestaurantsController@destroy');

Route::resource('offer', 'OffersController');
Route::post('search_offer', 'OffersController@SearchOffer')->name('search_offer');
Route::get('delete_offer/{id}', 'OffersController@destroy');

/*-------------------------------------------------------------------------------------------------*/
Route::get('list_term/{id}', 'TermsController@create');
Route::get('insert_term/{id}', 'TermsController@index');
Route::post('store_term', 'TermsController@store');

Route::get('term_th/{id}/edit/offer/{offer_id}', 'TermsController@term_th_edit');
Route::get('term_en/{id}/edit/offer/{offer_id}', 'TermsController@term_en_edit');
Route::get('term_cn/{id}/edit/offer/{offer_id}', 'TermsController@term_cn_edit');

Route::get('term_th_delete/{id}/offer/{offer_id}', 'TermsController@term_th_delete');
Route::get('term_en_delete/{id}/offer/{offer_id}', 'TermsController@term_en_delete');
Route::get('term_cn_delete/{id}/offer/{offer_id}', 'TermsController@term_cn_delete');

/*--------------------------------------------------------------------------------------------------*/

Route::resource('image', 'ImagesController');
Route::get('upload/{offer_id}', 'ImagesController@UploadImage')->name('upload_image');
//Route::get('delete_image/{id}', 'ImagesController@destroy');
Route::post('upload/image', 'ImagesController@store');
//Route::post('search_image', 'ImagesController@SearchImage');

Route::resource('balance', 'BalancesController');
Route::post('search_balance', 'BalancesController@SearchBalance')->name('search_balance');
Route::get('delete_balance/{id}', 'BalancesController@destroy');

/*--------------------------------------------------------------------------------------------------*/
Route::resource('report', 'ReportsController');

Route::post('search_report', 'ReportsController@SearchReports')->name('search_report');
Route::get('booking_pending', 'ReportsController@ListBookingPending')->name('list_pending');
Route::get('delete_report/{id}', 'ReportsController@destroy');

Route::get('get_restaurant', 'ReportsController@GetRestaurants');
Route::get('get_offer', 'ReportsController@GetOffers');

/*----------------------------------------------------------------------------------------------------*/

//Route::get('get_pdf', 'ReportPDFController@test')->name('get_pdf');

/*-----------------------------------------------------------------------------------------------------*/

Route::group(['prefix' => 'setting'], function () {

    Route::resource('users', '\App\Http\Controllers\Setting\User\UsersController');
    Route::get('delete_users/{id}', '\App\Http\Controllers\Setting\User\UsersController@destroy');
    Route::post('users_update_password', '\App\Http\Controllers\Setting\User\UsersController@update_password');

    Route::group(['prefix' => 'report'], function () {
        Route::resource('users', '\App\Http\Controllers\Setting\User\ReportUsersController');
        Route::get('delete_report_users/{id}', '\App\Http\Controllers\Setting\User\ReportUsersController@destroy');
    });

    Route::group(['prefix' => 'editor'], function () {
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

Route::get('test', function () {
    //return view('test.index');
});










