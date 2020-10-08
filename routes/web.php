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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login','LoginController@indexLogin')->name('login');
Route::get('/logout','LoginController@logout')->name('logout');
Route::post('/login/auth','LoginController@authLogin')->name('auth_login');

Route::get('/profile/{id}','UserController@index')->name('show_profile');

Route::get('/dashboard','DashboardController@index')->name('show_dashboard');


    // Leave Management
    Route::get('/leaveMaagement/requestApp','LeaveManagamentController@indexRequestapp')->name('show_requestApp');
    Route::get('/leaveMaagement/requestApp/add','LeaveManagamentController@addRequestapp')->name('add_requestApp');
    Route::get('/leaveMaagement/requestApp/check','LeaveManagamentController@checkRequestapp')->name('check_requestApp');
    Route::post('/leaveMaagement/requestApp/insert','LeaveManagamentController@insertRequestapp')->name('insert_requestApp');
    Route::get('/leaveMaagement/requestApp/{id}/edit','LeaveManagamentController@editRequestapp')->name('edit_requestApp');
    Route::post('/leaveMaagement/requestApp/update','LeaveManagamentController@updateRequestapp')->name('update_requestApp');
    Route::get('/leaveMaagement/requestApp/{id}/delete','LeaveManagamentController@deleteRequestapp')->name('delete_requestApp');
    Route::get('/leaveMaagement/leaveReport','LeaveManagamentController@indexLeavereport')->name('show_leaveReport');

    Route::get('/leaveMaagement/requestApp/approved/{id}','LeaveManagamentController@approvedRequestapp')->name('approved_requestApp');
    Route::get('/leaveMaagement/requestApp/rejected/{id}','LeaveManagamentController@rejectedRequestapp')->name('rejected_requestApp');
    Route::get('/leaveMaagement/requestApp/canceled/{id}','LeaveManagamentController@cancel_requestApp')->name('cancel_requestApp');


    // Attendance
    Route::get('/attendance/workshift','AttendanceController@indexWorkshift')->name('show_workshift');
    Route::post('/attendance/workshift/import','AttendanceController@importWorkshift')->name('bulk_workshift');
    Route::get('/attendance/workshift/export','AttendanceController@eksportWorkshift')->name('export_workshift');
    Route::get('/attendance/workshift/add','AttendanceController@addWorkshift')->name('add_workshift');
    Route::get('/attendance/workshift/insert','AttendanceController@insertWorkshift')->name('insert_workshift');

    Route::get('/attendance/report','AttendanceController@indexReport')->name('show_report');

    // schedule
    Route::get('/schedule','ScheduleController@index')->name('show_schedule');
    Route::post('/schedule','ScheduleController@importSchedule')->name('bulk_schedule');
    Route::post('/schedule/attlog','ScheduleController@importAttlog')->name('bulk_attlog');
    Route::get('/generateDate','ScheduleController@generateDate')->name('gen_date');
    Route::get('/schedule/checkSchedule','ScheduleController@checkSchedule')->name('checkSchedule');
    Route::POST('/schedule/findSchedule','ScheduleController@findSchedule')->name('findSchedule');
    Route::post('/insertSchedule','ScheduleController@insertSchedule')->name('insert_schedule');
    Route::get('/schedule/{id}/editSchedule','ScheduleController@editSchedule')->name('edit_schedule');
    Route::post('/updateSchedule','ScheduleController@updateSchedule')->name('update_schedule');
    Route::get('/schedule/{id}/deleteSchedule','ScheduleController@deleteSchedule')->name('delete_schedule');

    Route::get('/importschedule','ScheduleController@importyeah')->name('import_schedule');
    Route::get('/importsattendance','AttendanceController@importabsensi')->name('import_attendance');



    //Master Data

    // Department
    Route::get('/department','DepartmentController@index')->name('show_department');
    Route::post('/department','DepartmentController@importDepartment')->name('bulk_department');
    Route::post('/insertDepartment','DepartmentController@insertDepartment')->name('insert_department');
    Route::get('/department/{id}/edit','DepartmentController@editDepartment')->name('edit_department');
    Route::get('/department/{id}/delete','DepartmentController@deleteDepartment')->name('delete_department');
    Route::post('/updateDepartment','DepartmentController@updateDepartment')->name('update_department');
    Route::get('/department/export/', 'DepartmentController@eksportDepartment')->name('eksportDepartment');

    // Employee
    Route::get('/employee','EmployeeController@index')->name('show_employee');
    Route::post('/employeebulk','EmployeeController@importEmployee')->name('bulk_employee');
    Route::get('/employee/addEmployee','EmployeeController@addEmployee')->name('addEmployee');
    Route::post('/insertEmployee','EmployeeController@insertEmployee')->name('insert_employee');
    Route::get('/employee/{id}/edit','EmployeeController@editEmployee')->name('edit_employee');
    Route::get('/employee/{id}/delete','EmployeeController@deleteEmployee')->name('delete_employee');
    Route::post('/updateEmployee','EmployeeController@updateEmployee')->name('update_employee');
    Route::get('/employee/export/', 'EmployeeController@eksportEmployee')->name('eksportEmployee');

    // Payroll
    Route::get('/payroll','TaxSetupController@index')->name('show_taxsetup');

    Route::post('/payroll/taxsetup/import','TaxSetupController@importTaxsetup')->name('bulk_taxsetup');
    Route::post('/payroll/allowance/import','AllowanceController@importAllowance')->name('bulk_allowance');
    Route::post('/payroll/deduction/import','DeductionController@importDeduction')->name('bulk_deduction');

    Route::post('/payroll/insertSymbol','SymbolController@insertSymbol')->name('insert_symbol');
    Route::post('/payroll/insertTaxsetup','TaxSetupController@insertTaxsetup')->name('insert_taxsetup');
    Route::post('/payroll/insertLateconfig','LateConfigController@insertLateconfig')->name('insert_lateconfig');
    Route::post('/payroll/insertAllowance','AllowanceController@insertAllowance')->name('insert_allowance');
    Route::post('/payroll/insertDeduction','DeductionController@insertDeduction')->name('insert_deduction');

    Route::get('/payroll/{id}/editTaxsetup','TaxSetupController@editTaxsetup')->name('edit_taxsetup');
    Route::post('/payroll/updateTaxsetup','TaxSetupController@updateTaxsetup')->name('update_taxsetup');
    Route::get('/payroll/{id}/editLateconfig','LateConfigController@editLateconfig')->name('edit_lateconfig');
    Route::post('/payroll/updateLateconfig','LateConfigController@updateLateconfig')->name('update_lateconfig');
    Route::get('/payroll/{id}/editAllowance','AllowanceController@editAllowance')->name('edit_allowance');
    Route::post('/payroll/updateAllowance','AllowanceController@updateAllowance')->name('update_allowance');
    Route::get('/payroll/{id}/editDeduction','DeductionController@editDeduction')->name('edit_deduction');
    Route::post('/payroll/updateDeduction','DeductionController@updateDeduction')->name('update_deduction');
    Route::get('/payroll/{id}/editSymbol','SymbolController@editSymbol')->name('edit_symbol');
    Route::post('/payroll/updateSymbol','SymbolController@updateSymbol')->name('update_symbol');

    Route::get('/payroll/{id}/deleteTaxsetup','TaxSetupController@deleteTaxsetup')->name('delete_taxsetup');
    Route::get('/payroll/{id}/deleteLateconfig','LateConfigController@deleteLateconfig')->name('delete_lateconfig');
    Route::get('/payroll/{id}/deleteAllowance','AllowanceController@deleteAllowance')->name('delete_allowance');
    Route::get('/payroll/{id}/deleteDeduction','DeductionController@deleteDeduction')->name('delete_deduction');
    Route::get('/payroll/{id}/deleteSymbol','SymbolController@deleteSymbol')->name('delete_symbol');

    Route::get('/payroll/taxsetup/export/', 'TaxSetupController@eksportTaxsetup')->name('eksportTaxsetup');
    Route::get('/payroll/allowance/export/', 'AllowanceController@eksportAllowance')->name('eksportAllowance');
    Route::get('/payroll/deduction/export/', 'DeductionController@eksportDeduction')->name('eksportDeduction');


    // Route::get('/designation','DesignationController@index')->name('show_designation');

    // Leave Type
    Route::get('/leaveType','LeaveTypeController@index')->name('show_leaveType');
    Route::post('/leaveType','LeaveTypeController@insertLeavetype')->name('insert_leaveType');
    Route::get('/leaveType/{id}/editLeaveType','LeaveTypeController@editLeavetype')->name('edit_leaveType');
    Route::post('/leaveType/updateLeavetype','LeaveTypeController@updateLeavetype')->name('update_leaveType');
    Route::get('/leaveType/{id}/deleteLeaveType','LeaveTypeController@deleteLeavetype')->name('delete_leaveType');

    // status
    Route::get('/status','StatusController@index')->name('show_statusEmployee');
    Route::post('/status','StatusController@insertStatusemployee')->name('insert_statusEmployee');
    Route::post('/status/{id}/editStatus','StatusController@editStatusemployee')->name('edit_statusEmployee');
    Route::post('/status/updateStatusemployee','StatusController@updateStatusemployee')->name('update_statusEmployee');
    Route::post('/status/{id}/deleteStatus','StatusController@deleteStatusemployee')->name('delete_statusEmployee');


    // working time
    Route::get('/workingTime','WorkingTimeController@index')->name('show_workingTime');
    Route::post('/workingTime','WorkingTimeController@importWorkingtime')->name('bulk_workingTime');
    Route::post('/insertWorkingtime','WorkingTimeController@insertWorkingtime')->name('insert_workingTime');
    Route::get('/workingtime/{id}/editWorkingtime','WorkingTimeController@editWorkingtime')->name('edit_workingTime');
    Route::post('/updateWorkingtime','WorkingTimeController@updateWorkingtime')->name('update_workingTime');
    Route::get('/workingTime/{id}/deleteWorkingtime','WorkingTimeController@deleteWorkingtime')->name('delete_workingTime');
    Route::get('/workingTime/export/', 'WorkingTimeController@eksportWorkingtime')->name('eksportWorkingtime');


