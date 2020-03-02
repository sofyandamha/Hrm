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

Route::get('/department','DepartmentController@create')->name('insert_department');

Route::get('/designation','DesignationController@index')->name('show_designation');
