<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bulkScheduleku', 'ScheduleBulkcontroller@importyeah');
Route::get('/bulkAttendanceku', 'AttendanceController@importabsensi');

Route::post('/getAbsensiMonth', 'APIAbsensiReport@getAbsensi');
Route::post('/getAbsensiMonthEmp', 'APIAbsensiReport@getAbsensiEmp');
Route::post('/formTgsLr', 'APIFormController@formTgsLr');
Route::post('/formIznTdkMsk', 'APIFormController@formIznTdkMsk');
Route::post('/formAbsnMnl', 'APIFormController@formAbsnMnl');
Route::get('/getLeaveType', 'APIFormController@getLeaveType');
Route::post('/getHistoryForm', 'APIFormController@getHistoryForm');
