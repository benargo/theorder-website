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
    $recruiting_classes = DB::table('wow_classes')
        ->select('name', 'is_recruiting')
        ->where('is_recruiting', true)
        ->orderBy('name', 'asc')
        ->get();

    return view('home', [
        'recruiting_classes' => $recruiting_classes,
    ]);
})->name('homepage');

/*
 |--------------------------------------------------------------------------
 | Account
 |--------------------------------------------------------------------------
 */

Route::get('/account', function () {
    return redirect('/account/settings');
});

Route::get('/account/settings', 'Account\SettingsController@settingsPage');

Route::get('/account/character-select', function () {
    abort(404);
})->name('character-select');

// Route::get('/account/character-select', 'Account\CharacterSelectController@showCharacterList')
//         ->middleware('auth')
//         ->name('character-select');

/*
 |--------------------------------------------------------------------------
 | Applications
 |--------------------------------------------------------------------------
 */

Route::get('/join', 'ApplicationsController@showJoinPage')
    ->middleware('auth');

// Route::get('/join', function () {
//     return abort(504);
// });

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

Route::get('/bank', function () {
    return view('guild_bank_index');
});

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

        Route::get('/applications', 'ApplicationsController@all');

        Route::get('/guild-bank/clients', function () {
            return view('view_api_clients');
        });

        Route::get('/guild-bank/bankers', function () {
            return view('manage_bankers');
        });

        Route::get('/news', function () {
            return view('manage_news_items');
        });

        Route::get('/news/create', 'NewsItemController@create');

        Route::get('/news/editor/{news_item}', 'NewsItemController@edit');

        Route::get('/raids', function () {
            return redirect()->route('manage-raids');
        });

        Route::get('/raids/schedule', function (App\Blizzard\Warcraft\Instances\Raids $raids) {
            return view('controlpanel/manage_raid_schedule', [
                'instances' => $raids->toJson(),
            ]);
        });

        Route::get('/raids/signups', function () {
            return view('controlpanel/manage_raids');
        })->name('manage-raids');

        Route::get('/ranks', 'RanksController@manage');
    }
);

/*
 |--------------------------------------------------------------------------
 | Legal
 |--------------------------------------------------------------------------
 */

Route::get('/privacy', function () {
    return view('privacy_policy');
});

Route::get('/battlenet', function () {
    return view('battlenet_usage_information');
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

/*
 |--------------------------------------------------------------------------
 | Marketplace
 |--------------------------------------------------------------------------
 */

Route::get('/marketplace', 'MarketplaceController@getIndex');

Route::get('/marketplace/{action}');

/*
 |--------------------------------------------------------------------------
 | Raiding
 |--------------------------------------------------------------------------
 */

Route::get('/raids', function () {
    return view('');
});

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

/*
 |--------------------------------------------------------------------------
 | JSON Schemas
 |--------------------------------------------------------------------------
 */
Route::get('schema/stock.update.json', 'JsonSchemaController@stockUpdateSchema');
