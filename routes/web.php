<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('listings', 'ListingController')->except(['index']);
Route::resource('/listings/{listing}/tasks', 'TaskController');
Route::resource('users', 'UserController', ['only' => ['edit', 'update', 'show']]);

// ログインURL
Route::get('auth/twitter', 'Auth\TwitterController@redirectToProvider')->name('twitter.login');;
// コールバックURL
Route::get('auth/twitter/callback', 'Auth\TwitterController@handleProviderCallback')->name('twitter.callback');