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

Route::get('/', 'HomeController@renderHomepage')
        ->name('homepage');

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
Route::group(
    [
        'middleware' => 'can:access-inner-circle-control-panel',
        'prefix' => '/inner-circle',
    ],
    function () {
        Route::get('', function () {
            return view('control_panel');
        });

        Route::get('/news', function () {
            return view('manage_news_items');
        });

        Route::get('/news/create', 'NewsItemController@create');

        Route::get('/news/editor/{news_item?}', 'NewsItemController@edit');
    }
);

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

/*
 |--------------------------------------------------------------------------
 | News
 |--------------------------------------------------------------------------
 */
Route::group(
    [
        'prefix' => '/news',
    ],
    function () {
        Route::get('/', 'NewsItemController@index')
                ->name('news.index');

        Route::get('/{news_item}', function (App\Models\NewsItem $news_item) {
            return view('news_single', ['news_item' => $news_item]);
        })->name('news.single');
    }
);
