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

Route::get('/', 'HomeController@renderHomepage');
Route::get('discord', 'DiscordController@redirectToServer');
Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/battlenet/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('login/discord/callback', 'DiscordController@handleProviderCallback');
Route::get('logout', 'Auth\LogoutController@handleLogout');
