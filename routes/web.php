<?php

use Illuminate\Support\Facades\Route;
use App\Charts\SampleChart;

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

Route::get('/', 'DashboardController@dashboard_default');
Route::get('/DashboardPage', 'DashboardController@dashboard_default')->name('dashboardpage');
// Dashboard
Route::get('/policy/{TGX}', 'DashboardController@index');

// DrugPage
Route::get('/DrugPage', function () {
    return view('drugpage');
})->name('drugpage');
//Search Filter in DrugPage 
Route::get('/search', 'SearchController@index');

Route::get('/HospitalPage', 'HospitalController@filter')->name('hospitalpage');
//Search Filter in HospitalPage 
Route::get('/searchHos', 'HospitalController@index');
//Hospital Dashboard Page
Route::get('/HospitalDashboardPage', function () {
    return view('HospitalDashboardPage');
})->name('HospitalDashboardPage');
Route::get('/hospitalDashboard/{year}/{Hname}', 'HospitalDashboardController@index');


//Hospital User Dashboard Page
Route::get('/DashboardHosUser', 'HosUserDashboardController@default')->name('DashboardHosUser');
Route::get('/DashboardHosUser/{year}/{Hid}', 'HosUserDashboardController@index');
//Hospital User Drug Page
Route::get('/DrugPageHosUser', function () {
    return view('DrugHosUser');
})->name('DrugPageHosUser');
//Hospital User Search Filter in DrugPage 
Route::get('/searchDrugHosUser', 'HosUserDrugController@index');

