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
Route::post('/getAbsensiLogMonthEmp', 'APIAbsensiReport@getAbsensiLogMonthEmp');
Route::get('/getLocAbsen', 'APIAbsensiReport@getLocAbsen');
Route::post('/formTgsLr', 'APIFormController@formTgsLr');
Route::post('/formIznTdkMsk', 'APIFormController@formIznTdkMsk');
Route::post('/formAbsnMnl', 'APIFormController@formAbsnMnl');
Route::get('/getLeaveType', 'APIFormController@getLeaveType');
Route::post('/getHistoryForm', 'APIFormController@getHistoryForm');
Route::post('/getAttendanceNow', 'APIFormController@getAttendanceNow');
Route::post('/getLngLat', 'APIFormController@getLngLat');
Route::post('/signIn', 'APIFormController@signIn');
Route::post('/scanBarcodeIn', 'APIFormController@scanBarcodeIn');
Route::post('/signOut', 'APIFormController@signOut');
Route::post('/scanBarcodeOut', 'APIFormController@scanBarcodeOut');
Route::post('/changePassword', 'APIFormController@changePassword');
Route::get('/getEmployeeAbsenScan', 'APIFormController@getEmployeeAbsenScan');
Route::post('/getImeiDevice', 'ImeiDeviceController@getImei');
Route::post('/loginOtentikasiHrd', 'ImeiDeviceController@loginOtentikasiHrd');
Route::get('/getOtentikasiEmployee', 'ImeiDeviceController@getOtentikasiEmployee');
Route::post('/regisOtentikasiHrd', 'ImeiDeviceController@regisOtentikasiHrd');
Route::post('/loginUser', 'ImeiDeviceController@loginUser');
Route::get('/getImeiApproved', 'ImeiDeviceController@getImeiApproved');


