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

Route::get('/', function () {
    return view('Dashboard-GPU');
});

// Route::get('/testChart', 'UserChartController@index');

Route::get('/DashboardPage', function () {
    return view('dashboardpage');
})->name('dashboardpage');

Route::get('/DrugPage', function () {
    return view('drugpage');
})->name('drugpage');

Route::get('/HospitalPage', function () {
    return view('hospitalpage');
})->name('hospitalpage');
Route::get('/testDB', 'EbiddingController@testDB');
Route::get('/testDB2', 'DashboardController@getTOP5GPU');

// Dashboard
Route::get('/policy/{TGX}', 'DashboardController@index');
//Search Filter in DrugPage 
Route::get('/DrugPage/search', 'SearchController@index');

Route::get('/policy', 'DashboardController@policy')->name('policy_dashboard');
Route::get('/ebidding', 'EbiddingController@getEbiddingInfo');
Route::get('/ebidding15', 'EbiddingController@getEbiddingInfo15');
Route::get('/ebiddingAny/{id}', 'EbiddingController@getEbiddingInfoAny');
Route::post('/ebiddingAny', 'EbiddingController@getEbiddingInfoInput');
