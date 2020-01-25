<?php

/*
| Author:   DeGod
| Date:     February 28, 2019
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can find all web routes for this application. 
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PagesController@index');
Route::get('/ajax-save', 'PagesController@ajaxSave');
Route::get('/ajax-edit', 'PagesController@ajaxEdit');
Route::get('/ajax-delete/{index}', 'PagesController@ajaxDelete');
Route::get('/ajax-get', 'PagesController@ajaxGet');

