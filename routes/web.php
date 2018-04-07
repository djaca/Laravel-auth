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

Route::get('/social/redirect/{provider}', 'Auth\SocialController@redirectToProvider')->name('login.social');
Route::get('/social/handle/{provider}', 'Auth\SocialController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');
