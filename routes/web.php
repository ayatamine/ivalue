<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PdfController;
use App\Http\Controllers\User\CityController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\KindController;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EstateController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\TechniqueController;
use App\Http\Controllers\User\Notificationontroller;
use App\Http\Controllers\User\TechniqueTypeController;
use App\Http\Controllers\User\Incomes\Substitution\FarmController;
use App\Http\Controllers\User\Incomes\Substitution\LandController;
use App\Http\Controllers\User\Incomes\Substitution\BuildController;
use App\Http\Controllers\User\Incomes\Substitution\ParkingController;
use App\Http\Controllers\User\Incomes\Substitution\PetrolStationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

View::creator('frontend.layout.master', function ($view) {
    $view->with('option' , \App\Models\Option::find(1));
});
Route::group([ 'middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::resource('front_estates', EstateController::class)->only('index','show');
    // Route::resource('investments', Incomes\InvestmentController::class, ['only' => ['index','create','store','show']]);
    // Route::get('investment_delete/{id}', [Incomes\InvestmentController::class,'delete'])->name('investment_delete');
    Route::get('show_calendar/{slug}', [EstateController::class,'show_calendar'])->name('show_calendar');
    Route::get('show_report/{slug}', [EstateController::class,'show_report'])->name('show_report');
    Route::get('show_reports/{slug}', [EstateController::class,'show_reports'])->name('show_reports');
    Route::resource('front_reports', ReportController::class)->only('index');
    Route::resource('front_pages', PageController::class)->only('index','show');
    Route::get('profile', [ProfileController::class,'edit'])->name('edit_pro');
    Route::patch('profile_update', [ProfileController::class ,'update'])->name('update_pro');


    Route::resource('countries', CountryController::class)->except(['show']);
    Route::delete('delete_countries', [CountryController::class,'delete_countries'])->name('delete_countries');
    /*********** end countries route ***********/
    /***********  cities route ***********/
    Route::resource('cities', CityController::class)->except(['show']);
    Route::delete('delete_cities', [CityController::class,'delete_cities'])->name('delete_cities');

    /***********  categories route ***********/
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::delete('delete_categories', [CategoryController::class,'delete_categories'])->name('delete_categories');


 /***********  techniques route ***********/
    Route::resource('techniques', TechniqueController::class)->except(['show']);
    Route::delete('delete_techniques', [TechniqueController::class,'delete_techniques'])->name('delete_techniques');

 /***********  technique types route ***********/
    Route::resource('technique-types', TechniqueTypeController::class)->except(['show']);
    Route::delete('delete_technique_types', [TechniqueTypeController::class,'delete_technique_types'])->name('delete_technique_types');

    /***********  kinds route ***********/
    Route::resource('kinds', KindController::class)->except(['show']);
    Route::delete('delete_kinds', [KindController::class,'delete_kinds'])->name('delete_kinds');
    /*********** end cities route ***********/
    /***********  estates route ***********/
    Route::resource('estates', EstateController::class)->except(['show']);
    Route::get('archive', [EstateController::class,'archive'])->name('archive');
    Route::get('estate_paid/{estate_id}',  [EstateController::class,'estate_paid'])->name('estate_paid');
    Route::post('estate_paid/{estate_id}', [EstateController::class,'estate_paid_post'])->name('estate_paid_post');

    Route::get('admins', [UserController::class,'admins'])->name('admins');
    Route::resource('users', UserController::class)->except(['show']);

//    level report
    Route::get('notification-level/{not_id}', [Notificationontroller::class,'not_open'])->name('not_open');
    Route::patch('level-refuse/{estate_id}/{type}', [Notificationontroller::class,'level_refuse'])->name('level_refuse');
    Route::patch('level_inputs/{estate_id}', [Notificationontroller::class,'level_inputs'])->name('level_inputs');

//    settings
    Route::get('settings', [SettingController::class,'index'])->name('settings');
    Route::patch('update_settings', [SettingController::class,'update_settings'])->name('update_settings');
    
    Route::get('edit_archive/{estate_id}', [Notificationontroller::class,'edit_archive'])->name('edit_archive');
Route::post('edit_archive_post/{estate_id}',[Notificationontroller::class,'edit_archive_post'])->name('edit_archive_post');
});

Route::get('pdf', [PdfController::class,'generatePDF'])->name('pdf');
Route::get('show_pdf/{id}', [PdfController::class,'show_pdf'])->name('show_pdf');
Route::get('pdf/{id}', [PdfController::class,'generatePDF_pro'])->name('pdf_pro');
Route::get('report_page', [PdfController::class,'report_page'])->name('report_page');
Route::post('report_form', [PdfController::class,'report_form'])->name('report_form');



Route::group([ 'middleware' => 'auth'], function () {
    //incoms
    Route::resource('substitution/land', LandController::class)->only(['index','create','store','show']);
    Route::get('land_delete/{id}',[LandController::class,'delete'])->name('land_delete');

    Route::resource('substitution/build', BuildController::class)->only(['index','create','store','show']);
    Route::get('build_delete/{id}', [BuildController::class,'delete'])->name('build_delete');

    Route::resource('substitution/parking', ParkingController::class)->only(['index','create','store','show']);
    Route::get('parking_delete/{id}', [ParkingController::class,'delete'])->name('parking_delete');

    Route::resource('substitution/petrol_station', PetrolStationController::class)->only(['index','create','store','show']);
    Route::get('petrol_station_delete/{id}', [PetrolStationController::class,'delete'])->name('petrol_station_delete');

    Route::resource('substitution/farm', FarmController::class)->only(['index','create','store','show']);
    Route::get('farm_delete/{id}', [FarmController::class,'delete'])->name('farm_delete');
});



// Auth::routes();

Route::post('/dark_mode', [App\Http\Controllers\User\HomeController::class,'darkmode']);
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';