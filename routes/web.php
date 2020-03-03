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

// Department
Route::get('/department','DepartmentController@index')->name('show_department');

Route::post('/department','DepartmentController@importDepartment')->name('bulk_department');

Route::post('/insertDepartment','DepartmentController@insertDepartment')->name('insert_department');

Route::get('/department/{id}/edit','DepartmentController@editDepartment')->name('edit_department');

Route::get('/department/{id}/delete','DepartmentController@deleteDepartment')->name('delete_department');

Route::post('/updateDepartment','DepartmentController@updateDepartment')->name('update_department');

Route::get('department/export/', 'DepartmentController@eksportDepartment')->name('eksportDepartment');

// Employee
Route::get('/employee','EmployeeController@index')->name('show_employee');

Route::post('/employee','EmployeeController@importEmployee')->name('bulk_employee');

Route::post('/insertemployee','EmployeeController@insertEmployee')->name('insert_employee');

Route::get('/employee/{id}/edit','EmployeeController@editEmployee')->name('edit_employee');

Route::get('/employee/{id}/delete','EmployeeController@deleteEmployee')->name('delete_employee');

Route::post('/updateemployee','EmployeeController@updateEmployee')->name('update_employee');

Route::get('employee/export/', 'EmployeeController@eksportEmployee')->name('eksportEmployee');

Route::get('/designation','DesignationController@index')->name('show_designation');
