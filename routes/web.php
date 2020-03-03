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

Route::get('/department','DepartmentController@index')->name('show_department');

Route::post('/department','DepartmentController@importDepartment')->name('bulk_department');

Route::get('/department/{id}/edit','DepartmentController@editDepartment')->name('edit_department');

Route::get('/department/{id}/delete','DepartmentController@deleteDepartment')->name('delete_department');

Route::post('/updateDepartment','DepartmentController@updateDepartment')->name('update_department');


Route::get('/designation','DesignationController@index')->name('show_designation');
