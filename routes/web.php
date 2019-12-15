<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('listings', 'ListingController')->except(['index']);
Route::resource('/listings/{listing}/tasks', 'TaskController');
Route::resource('users', 'UserController', ['only' => ['edit', 'update', 'show']]);