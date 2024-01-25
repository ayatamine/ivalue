<?php

use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PdfController;
use App\Http\Controllers\User\CityController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\KindController;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ZoneController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Middleware\IsNotClientMiddleware;
use App\Http\Controllers\User\EstateController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\TechniqueController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\User\Notificationontroller;
use App\Http\Controllers\User\ClientEstateController;
use App\Http\Controllers\User\TechniqueTypeController;
use App\Http\Controllers\User\Incomes\InvestmentController;
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


// Auth::routes();

Route::post('/dark_mode', [App\Http\Controllers\User\HomeController::class,'darkmode']);
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


 require __DIR__.'/auth.php';
Route::group(['domain' => '{subdomain}.' . config('app.url'), 'middleware' => ['tenant']], function () {
Route::get('amie',function(){
});
    // dd(Establishment::all());
    //   \DB::statement("INSERT INTO `establishments` (`id`, `name`, `name_en`, `bio`, `email`, `phone1`, `phone2`, `whatstapp_number`, `website_link`, `address`, `currency`, `commercial_register_number`, `commercial_register_photo`, `commercial_register_end_at`, `tax_number`, `tax_certificate_image`, `license_number`, `license_image`, `evaluation_branch`, `evaluation_end_date`, `created_at`, `updated_at`, `data`, `domain`, `database`, `database_username`, `database_password`, `admin_id`) VALUES (NULL, 'منشأة جديدة', 'amine', NULL, 'new_admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-08 08:47:44', '2024-01-08 08:47:44', NULL, 'amine', 'ysmmklvs2n', 'root', '', '25');");
    View::creator('frontend.layout.master', function ($view) {
        $view->with('option' , \App\Models\Option::find(1));
    });
    Route::group([ 'middleware' => ['auth',IsNotClientMiddleware::class]], function () {
        Route::get('/', [HomeController::class,'index'])->name('home');
        Route::resource('front_estates', EstateController::class)->only('index','show');
        Route::resource('investments', InvestmentController::class)->only(['index','create','store','show']);
        Route::get('investment_delete/{id}', [InvestmentController::class,'delete'])->name('investment_delete');
        Route::get('show_calendar/{slug}', [EstateController::class,'show_calendar'])->name('show_calendar');
        Route::get('show_report/{slug}', [EstateController::class,'show_report'])->name('show_report');
        Route::get('show_reports/{slug}', [EstateController::class,'show_reports'])->name('show_reports');
        Route::resource('front_reports', ReportController::class)->only('index');
        Route::resource('front_pages', PageController::class)->only('index','show');
        Route::get('profile', [ProfileController::class,'edit'])->name('edit_pro');
        Route::patch('profile_update', [ProfileController::class ,'update'])->name('update_pro');


        Route::resource('countries', CountryController::class)->except(['show']);
        Route::delete('delete_countries', [CountryController::class,'delete_countries'])->name('delete_countries');

        Route::get('/cities/by-country/{country}', [CityController::class,'countryCities'])->name('cities.get');

        /*********** end countries route ***********/
        /***********  cities route ***********/
        Route::resource('cities', CityController::class)->except(['show']);
        Route::delete('delete_cities', [CityController::class,'delete_cities'])->name('delete_cities');

        Route::resource('zones', ZoneController::class)->except(['show']);
        Route::delete('delete_zones', [ZoneController::class,'delete_zones'])->name('delete_zones');
        Route::get('/zones/by-country/{country}', [ZoneController::class,'countryZones'])->name('zones.get');

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
        Route::get('drafts', [EstateController::class,'drafts'])->name('drafts');
        Route::get('estate_paid/{estate_id}',  [EstateController::class,'estate_paid'])->name('estate_paid');
        Route::post('estate_paid/{estate_id}', [EstateController::class,'estate_paid_post'])->name('estate_paid_post');

        Route::get('admins', [UserController::class,'admins'])->name('admins');
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);

    //    level report
        Route::get('notification-level/{not_id}', [Notificationontroller::class,'not_open'])->name('not_open')->withoutMiddleware([IsNotClientMiddleware::class]);
        Route::patch('level-refuse/{estate_id}/{type}', [Notificationontroller::class,'level_refuse'])->name('level_refuse');
        Route::patch('level_inputs/{estate_id}', [Notificationontroller::class,'level_inputs'])->name('level_inputs');
        Route::get('complete_entry/{estate_id}',[Notificationontroller::class,'completeEntry'])->name('complete_entry');
        Route::get('estate_order_reopen/{estate_id}',[Notificationontroller::class,'reopenEstateOrder'])->name('reopen_estate_order')->withoutMiddleware([IsNotClientMiddleware::class]);
        Route::patch('client_level_inputs/{estate_id}', [Notificationontroller::class,'level_inputs'])->name('client_level_inputs')->withoutMiddleware([IsNotClientMiddleware::class]);

    //    settings
        Route::get('settings', [SettingController::class,'index'])->name('settings');
        Route::get('settings/reports', [SettingController::class,'reportsSettings'])->name('settings.reports');
        Route::get('settings/rating', [SettingController::class,'ratingSettings'])->name('settings.rating');
        Route::patch('update_settings', [SettingController::class,'update_settings'])->name('update_settings');
        Route::patch('update_reports_settings', [SettingController::class,'update_reports_settings'])->name('update_reports_settings');
        Route::patch('update_rating_settings', [SettingController::class,'update_rating_settings'])->name('update_rating_settings');

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
        Route::resource('substitution/land', LandController::class);
        Route::get('land_delete/{id}',[LandController::class,'delete'])->name('land_delete');

        Route::resource('substitution/build', BuildController::class);
        Route::get('build_delete/{id}', [BuildController::class,'delete'])->name('build_delete');

        Route::resource('substitution/parking', ParkingController::class);
        Route::get('parking_delete/{id}', [ParkingController::class,'delete'])->name('parking_delete');

        Route::resource('substitution/petrol_station', PetrolStationController::class);
        Route::get('petrol_station_delete/{id}', [PetrolStationController::class,'delete'])->name('petrol_station_delete');

        Route::resource('substitution/farm', FarmController::class);
        Route::get('farm_delete/{id}', [FarmController::class,'delete'])->name('farm_delete');
    });

    Route::get('/client/dashboard', [HomeController::class,'clientDashboard'])->name('client_home');
    Route::resource('client/estates', ClientEstateController::class,[
        'as' => 'client'
    ])->except(['show']);
    Route::get('client/archive', [ClientEstateController::class,'archive'])->name('client.archive');


});
Route::resource('establishments',App\Http\Controllers\Admin\EstablishmentController::class);
