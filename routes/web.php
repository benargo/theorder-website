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

Route::name('homepage')
     ->get('/', 'HomeController@renderHomepage');

/*
 |--------------------------------------------------------------------------
 | Account
 |--------------------------------------------------------------------------
 */

Route::name('account.index')
     ->get('/account', function () {
         return redirect('/account/settings');
     });

Route::name('account.settings')
     ->middleware('auth')
     ->get('/account/settings', 'Account\SettingsController@settingsPage');

/*
 |--------------------------------------------------------------------------
 | Applications
 |--------------------------------------------------------------------------
 */

Route::get('/join', 'ApplicationsController@showJoinPage')
    ->middleware('auth');

/*
 |--------------------------------------------------------------------------
 | Discord
 |--------------------------------------------------------------------------
 */

Route::get('/discord', 'DiscordController@main');

Route::get('/discord/channels/{channel}', 'DiscordController@main')
    ->name('discord-channel');

Route::get('/discord/link', 'DiscordController@linkAccount');

Route::get('/oauth2/discord', 'DiscordController@handleProviderCallback');

/*
 |--------------------------------------------------------------------------
 | Guild Bank
 |--------------------------------------------------------------------------
 */

Route::name('bank.index')
     ->get('/bank', function () {
         return view('guild_bank_index');
     });

/*
 |--------------------------------------------------------------------------
 | Inner Circle Control Panel
 |--------------------------------------------------------------------------
 |
 | This has now been replaced by the Officers' Control Panel. The routes for
 | which can be found in the 'routes\control_panel.php' file. These routes
 | remain here to act as redirects to the new location, for those authenticated
 | to a suitable level to see them.
 |
 */

Route::middleware('can:access-officers-control-panel')
     ->get('/inner-circle{route?}', function ($route = null) {
         return redirect("/officers{$route}");
     })
     ->where('route', '.*');

/*
 |--------------------------------------------------------------------------
 | Legal
 |--------------------------------------------------------------------------
 */

Route::name('privacy_policy')
     ->get('/privacy', function () {
         return view('privacy_policy');
     });

Route::name('battlenet_usage_information')
     ->get('/battlenet', function () {
         return view('battlenet_usage_information');
     });

/*
 |--------------------------------------------------------------------------
 | Login/Logout
 |--------------------------------------------------------------------------
 */

Route::name('login')
     ->get('/login', 'Auth\LoginController@redirectToProvider');

Route::name('login.callback')
     ->get('/oauth2/battlenet', 'Auth\LoginController@handleProviderCallback');

Route::name('logout')
     ->get('/logout', 'Auth\LogoutController@handleLogout');

/*
 |--------------------------------------------------------------------------
 | Marketplace
 |--------------------------------------------------------------------------
 */

// Route::get('/marketplace', 'MarketplaceController@getIndex');

// Route::get('/marketplace/{action}');

/*
 |--------------------------------------------------------------------------
 | Raiding
 |--------------------------------------------------------------------------
 */

Route::name('raids.index')
     ->get('/raids', function () {
         return view('view_raiding_schedule');
     });

Route::name('raids.single')
     ->middleware('auth')
     ->get('/raids/{raid}', 'ViewRaidController@get');

/*
 |--------------------------------------------------------------------------
 | News
 |--------------------------------------------------------------------------
 */

Route::prefix('/news')->group(function () {
    Route::name('news.index')
         ->get('/', 'NewsItemController@index');

    Route::name('news.single')
         ->get('/{news_item}', function (App\Models\NewsItem $news_item) {
             return view('news_single', ['news_item' => $news_item]);
         });
});

/*
 |--------------------------------------------------------------------------
 | JSON Schemas
 |--------------------------------------------------------------------------
 */
Route::get('schema/stock.update.json', 'JsonSchemaController@stockUpdateSchema');
