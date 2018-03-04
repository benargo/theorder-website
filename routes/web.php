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

/*
 |--------------------------------------------------------------------------
 | Account
 |--------------------------------------------------------------------------
 */
Route::get('account/character-select', 'Account\CharacterSelectController@showCharacterList')
    ->middleware('auth')
    ->name('character-select');

/*
 |--------------------------------------------------------------------------
 | Discord
 |--------------------------------------------------------------------------
 */
Route::get('discord', 'DiscordController@redirectToServer');
Route::get('login/discord/callback', 'DiscordController@handleProviderCallback');

/*
 |--------------------------------------------------------------------------
 | Login/Logout
 |--------------------------------------------------------------------------
 */
Route::get('login', 'Auth\LoginController@redirectToProvider')
    ->name('login');
Route::get('login/battlenet/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LogoutController@handleLogout');
