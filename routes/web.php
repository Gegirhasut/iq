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

Route::get('/', 'HomeController@index')->name('home');

Route::post('/add', 'HomeController@add')->name('add');

Route::post('/operation', 'OperationController@user')->name('operation');

Route::post('/operation/hold', 'OperationController@hold')->name('hold');