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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/user/applications', 'Account\ApplicationsController@get');

Route::middleware('auth:api')->post('/user/{user}/unlink-discord', 'Account\SettingsController@unlinkDiscord');

Route::middleware('auth:api')->put('/user/{user}/{field}', 'Account\SettingsController@updateUserField');

/*
 |--------------------------------------------------------------------------
 | Applications
 |--------------------------------------------------------------------------
 */

Route::middleware('auth:api')->get('/applications', 'ApplicationsController@getCollection');

Route::middleware('auth:api')->post('/applications/new', 'ApplicationsController@create');

Route::middleware('auth:api')->patch('/applications/{application}', 'ApplicationsController@patch');

/*
 |--------------------------------------------------------------------------
 | Character Select
 |--------------------------------------------------------------------------
 |
 | This route is not currently used by this aopplication.
 |
 */

// Route::middleware('auth:api')->put('/primary-character/{user}', 'Account\CharacterSelectController@setPrimaryCharacter');

/*
 |--------------------------------------------------------------------------
 | Guild Bank
 |--------------------------------------------------------------------------
 */

Route::get('/guild-bank/stock', function () {
    return response()->json(
        DB::table('guild_bank_stock')
            ->whereNull('withdrawn_at')
            ->get()
            ->toJson()
    );
});

Route::post('/guild-bank/stock/update', 'GuildBank\StockController@updateStock')
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

Route::middleware('auth:api')->group(function () {
    Route::get('/notifications/unread', 'NotificationsController@getUnreadNotifications');
});

/*
 |--------------------------------------------------------------------------
 | Ranks
 |--------------------------------------------------------------------------
 */

Route::get('/ranks', 'RanksController@get');

Route::post('/ranks/new', 'RanksController@create');

Route::put('/ranks/{rank}', 'RanksController@update')->middleware([
    'auth:api',
    'can:update,rank',
]);

Route::delete('/ranks/{rank}', 'RanksController@delete')->middleware([
    'auth:api',
    'can:delete,rank',
]);

Route::get('/ranks/{rank}/users', 'RanksController@users')->middleware([
    'auth:api',
    'can:seeUsers,rank',
]);
