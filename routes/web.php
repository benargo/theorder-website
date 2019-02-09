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

Route::get('/', 'HomeController@renderHomepage')->name('homepage');

/*
 |--------------------------------------------------------------------------
 | Account
 |--------------------------------------------------------------------------
 */
Route::get('/account/character-select', 'Account\CharacterSelectController@showCharacterList')
    ->middleware('auth')
    ->name('character-select');

/*
 |--------------------------------------------------------------------------
 | Discord
 |--------------------------------------------------------------------------
 */
Route::get('/discord', 'DiscordController@redirectToServer');
Route::get('/oauth2/discord', 'DiscordController@handleProviderCallback');

/*
 |--------------------------------------------------------------------------
 | Inner Circle Control Panel
 |--------------------------------------------------------------------------
 */
Route::group([
    'middleware' => 'can:access-inner-circle-control-panel',
    'prefix' => '/inner-circle',
], function () {
    Route::get('', function () {
        return view('control_panel');
    });

    Route::get('/news/create', 'NewsItemController@create');
});

/*
 |--------------------------------------------------------------------------
 | Login/Logout
 |--------------------------------------------------------------------------
 */
Route::get('/login', 'Auth\LoginController@redirectToProvider')
    ->name('login');
Route::get('/oauth2/battlenet', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback');
Route::get('/logout', 'Auth\LogoutController@handleLogout');
