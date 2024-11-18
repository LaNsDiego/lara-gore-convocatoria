<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('verify/login', 'Auth\AuthenticationController@login');

Route::get('job-titles/list', 'JobTitleController@list');
Route::post('job-titles/store', 'JobTitleController@store');
Route::post('job-titles/update', 'JobTitleController@update');
Route::post('job-titles/delete', 'JobTitleController@destroy');

Route::get('job-profiles/list', 'JobProfileController@list');
Route::post('job-profiles/store', 'JobProfileController@store');
Route::post('job-profiles/update', 'JobProfileController@update');
Route::post('job-profiles/delete', 'JobProfileController@destroy');

Route::post('people/find-sir','PersonController@find_on_sir');

Route::get('employees/list', 'EmployeeController@list');
Route::post('employees/store', 'EmployeeController@store');

Route::get('countries/list', 'CountryController@list');