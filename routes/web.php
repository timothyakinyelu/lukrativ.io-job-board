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

/*
|-------------------------------------------------------------------------------
| Displays the application
|-------------------------------------------------------------------------------
| URL:            /
| Controller:     Web\AppController@loadSite
| Method:         GET
| Description:    Launches the application.
|
*/

Route::get('/{vue?}', 'Web\AppController@loadSite')->where('vue', '[\/\w\.-]*')->name('app');


