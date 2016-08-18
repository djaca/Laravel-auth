<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin');
})->middleware('role:admin');

// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm')->name('login');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\AuthController@register')->name('register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

// Socialite Github
Route::get('/social/redirect/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('login.social');
Route::get('/social/handle/{provider}', 'Auth\SocialAuthController@handleProviderCallback');