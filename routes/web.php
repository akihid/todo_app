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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('listings', 'ListingController');
Route::resource('/listings/{listing}/tasks', 'TaskController');
// Route::get('/listings/create', 'ListingController@create')->name('listings.create');
// Route::post('/listings/create', 'ListingController@store')->name('listings.store');
//   // Todo：　確認用のためタスク一覧作成時削除する
// Route::get('/listings', 'ListingController@index')->name('listings.index');