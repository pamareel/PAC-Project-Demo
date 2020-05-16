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

// Route::get('/DashboardPage', function () {
//     return view('Dashboard-GPU');
// })->name('dashboardpage');

// DrugPage
Route::get('/DrugPage', function () {
    return view('drugpage');
})->name('drugpage');
//Search Filter in DrugPage 
Route::get('/search', 'SearchController@index');

// Route::get('/HospitalPage', function () {
//     return view('hospitalpage');
// })->name('hospitalpage');

Route::get('/HospitalPage', 'HospitalController@filter')->name('hospitalpage');
//Search Filter in HospitalPage 
Route::get('/searchHos', 'HospitalController@index');
//Hospital Dashboard Page
Route::get('/HospitalDashboardPage', function () {
    return view('HospitalDashboardPage');
})->name('HospitalDashboardPage');
Route::get('/hospitalDashboard/{year}/{Hname}', 'HospitalDashboardController@index');

//Hospital User Dashboard Page รอใส่
Route::get('/DashboardHosUser', function () {
    return view('DrugHosUser');
})->name('DashboardHosUser');
//Hospital User Drug Page
Route::get('/DrugPageHosUser', function () {
    return view('DrugHosUser');
})->name('DrugPageHosUser');
//Search Filter in DrugPage 
Route::get('/searchDrugHosUser', 'HosUserDrugController@index');

Route::get('/policy', 'DashboardController@policy')->name('policy_dashboard');
Route::get('/ebidding', 'EbiddingController@getEbiddingInfo');
Route::get('/ebidding15', 'EbiddingController@getEbiddingInfo15');
Route::get('/ebiddingAny/{id}', 'EbiddingController@getEbiddingInfoAny');
Route::post('/ebiddingAny', 'EbiddingController@getEbiddingInfoInput');
