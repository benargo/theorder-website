<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 |--------------------------------------------------------------------------
 | Account
 |--------------------------------------------------------------------------
 */

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/applications', 'Account\ApplicationsController@get');

Route::post('/user/{user}/unlink-discord', 'Account\SettingsController@unlinkDiscord');

Route::put('/user/{user}/{field}', 'Account\SettingsController@updateUserField');

/*
 |--------------------------------------------------------------------------
 | Applications
 |--------------------------------------------------------------------------
 */

Route::get('/applications', 'ApplicationsController@getCollection');

Route::post('/applications/new', 'ApplicationsController@create');

Route::get('/applications/statistics', 'ApplicationsController@getStatistics');

Route::patch('/applications/{application}', 'ApplicationsController@patch');

/*
 |--------------------------------------------------------------------------
 | Character Select
 |--------------------------------------------------------------------------
 |
 | This route is not currently used by this aopplication.
 |
 */

// Route::put('/primary-character/{user}', 'Account\CharacterSelectController@setPrimaryCharacter');

/*
 |--------------------------------------------------------------------------
 | Guild Bank
 |--------------------------------------------------------------------------
 */

Route::get('/guild-bank/bankers', 'GuildBank\BankersController@getBankers')
    ->middleware(['can:view-bankers', 'cache.headers:etag']);

Route::post('/guild-bank/bankers', 'GuildBank\BankersController@updateBankers')
    ->middleware('can:update-stock-data');

Route::delete('/guild-bank/bankers/{banker}', 'GuildBank\BankersController@deleteBanker')
    ->middleware('can:update-stock-data');

Route::get('/guild-bank/stock', 'GuildBank\GetStockController@getStock')
    ->middleware('cache.headers:etag');

Route::post('/guild-bank/stock/update', 'GuildBank\UpdateStockController@postUpdateStock')
    ->middleware('can:update-stock-data');

/*
 |--------------------------------------------------------------------------
 | News Items
 |--------------------------------------------------------------------------
 */

Route::get('/news/check-url', 'NewsItemController@checkUrl');

Route::post('/news/create', 'NewsItemController@publish');

Route::put('/news/drafts/{draft}', 'NewsItemController@saveDraft');

Route::delete('/news/drafts/{draft}', function (App\Models\NewsItemDraft $draft) {
    $user = Auth::user();
    $user->can('delete', $draft);
    $draft->delete();
    return response(null, 204);
});

Route::get('/news/manager', 'NewsItemController@getManageList');

Route::get('/news/{news_item}', function (App\Models\NewsItem $news_item) {
    $user = Auth::user();
    $user->can('update', $news_item);
    return response($news_item);
});

Route::put('/news/{news_item}', 'NewsItemController@publish');

Route::delete('/news/{news_item}', function (App\Models\NewsItem $news_item) {
    $user = Auth::user();
    $user->can('delete', $news_item);
    $news_item->delete();
    return response(null, 204);
});

/*
 |--------------------------------------------------------------------------
 | Notifications
 |--------------------------------------------------------------------------
 */

Route::get('/notifications/unread', 'NotificationsController@getUnreadNotifications');

/*
 |--------------------------------------------------------------------------
 | Raid Schedular
 |--------------------------------------------------------------------------
 */

Route::get('/schedular/schedules', 'RaidSchedularController@getAllSchedules');

Route::post('/schedular/new', 'RaidSchedularController@createSchedule');

Route::get('/schedular/raids', 'RaidSchedularController@getAllRaids');

Route::get('/schedular/raids/{raid}', 'RaidSchedularController@getRaid');

Route::delete('/schedular/schedule/{schedule}', 'RaidSchedularController@deleteSchedule');

/*
 |--------------------------------------------------------------------------
 | Raid Signups
 |--------------------------------------------------------------------------
 */

Route::post('/raids/{raid}/signup', 'RaidSignUpController@create')
    ->middleware(\Illuminate\Session\Middleware\StartSession::class);

Route::delete('/raids/{raid}/signup/{signup}', 'RaidSignUpController@delete');

/*
 |--------------------------------------------------------------------------
 | Ranks
 |--------------------------------------------------------------------------
 */

Route::get('/ranks', 'RanksController@get');

Route::post('/ranks/new', 'RanksController@create');

Route::put('/ranks/{rank}', 'RanksController@update')
    ->middleware('can:update,rank');

Route::delete('/ranks/{rank}', 'RanksController@delete')
    ->middleware('can:delete,rank');

Route::get('/ranks/{rank}/users', 'RanksController@users')
    ->middleware('can:seeUsers,rank');
