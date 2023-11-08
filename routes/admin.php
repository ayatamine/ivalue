<?php

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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
Auth::routes();
/*******************************************************/
View::creator('backend.layout.navbar', function ($view) {
//    $view->with('eventcount' , \App\Models\Event::count());
});
View::creator('backend.layout.header', function ($view) {
});
/*************** backend routes *************/
// Route::get('admin/login', 'Admin\AdminauthController@showLoginFrom')->name('backendLogin');
// Route::post('admin/login', 'Admin\AdminauthController@login');
// Route::get('admin', 'Admin\AdminauthController@showLoginFrom');
// Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth:moderator'], function () {
//     /****************** auth routes ****************/
//     Route::get('dashboard', 'AdminController@index')->name('backend-home');
//     /***********  countries route ***********/
// //    Route::resource('countries', 'CountryController', ['except' => ['show']]);
// //    Route::delete('delete_countries', 'CountryController@delete_countries')->name('delete_countries');
// //    /*********** end countries route ***********/
// //    /***********  cities route ***********/
// //    Route::resource('cities', 'CityController', ['except' => ['show']]);
// //    Route::delete('delete_cities', 'CityController@delete_cities')->name('delete_cities');
// //    /*********** end cities route ***********/
// //    /***********  estates route ***********/
// //    Route::resource('estates', 'EstateController');
//     Route::get('calendar/{slug}', 'EstateController@calendar')->name('calendar');
//     Route::get('estate/log/{slug}', 'EstateController@log')->name('estate_log');
//     Route::delete('delete_estates', 'EstateController@delete_estates')->name('delete_estates');
//     /*********** end estates route ***********/
//     /***********  estates route ***********/
//     Route::get('all_infos/{slug}', 'ReportController@indexo')->name('all_infos');
//     Route::get('info/log/{slug}', 'ReportController@log')->name('info_log');
//     Route::resource('infos', 'ReportController',['except' => ['index']]);
//     Route::delete('delete_infos', 'ReportController@delete_infos')->name('delete_infos');
//     /*********** end estates route ***********/
//     /***********  ad Banners route ***********/
//     Route::resource('sliders', 'SliderController', ['except' => ['show']]);
//     Route::delete('delete_sliders', 'SliderController@delete_sliders')->name('delete_sliders');
//     /*********** end ad Banners route ***********/
//     /***********  pages route ***********/
//     Route::resource('pages', 'PageController', ['except' => ['show']]);
//     Route::delete('delete_pages', 'PageController@delete_pages')->name('delete_pages');
//     /*********** end pages route ***********/
//     /***********  users route ***********/
//     Route::resource('users', 'UserController');
//     Route::get('blocked', 'UserController@blocked')->name('blocked');
//     Route::get('users/blocked_btn/{id}', 'UserController@block_user')->name('blocked_btn');
//     Route::delete('delete_users', 'UserController@delete_users')->name('delete_users');
//     /***********  options route ***********/
//     Route::resource('options', 'OptionController', ['only' => ['edit', 'update']]);
//     /*********** end options route ***********/
//     Route::resource('moderators', 'ModeratorController', ['except' => ['show']]);
//     //***********  moderator route ***********/
//     //*********** send message route ***********/
//     Route::get('send/page', 'MessageController@message')->name('send_form');
//     Route::post('send/message', 'MessageController@send_message')->name('send');
//     //*********** end send message route ***********/

//     Route::get('imports', 'ExcelController@index')->name('imports');
//     Route::get('exports', 'ExcelController@exports')->name('exports');

//     Route::post('import', 'ExcelController@import')->name('import');
//     Route::post('export', 'ExcelController@export')->name('export');

// });
/************* ajax select routes ******************/
Route::get('/ajax-estates', [AdminController::class,'getestates']);
Route::post('read', [AdminController::class,'readNotification']);



