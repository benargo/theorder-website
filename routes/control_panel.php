<?php

/*
 |--------------------------------------------------------------------------
 | Officers' Control Panel
 |--------------------------------------------------------------------------
 |
 | This was formerly the Inner Circle Control Panel, but this has been changed
 | as of April 2020 to allow people of Commander rank to carry out more
 | management tasks on behalf of the guild.
 |
 */

Route::name('index')
     ->get('/', function () {
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

Route::name('manage_ranks')
     ->get('/ranks', 'RanksController@manage');
