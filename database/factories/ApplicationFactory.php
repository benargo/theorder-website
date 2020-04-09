<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Guild\Application::class, function (Faker $faker) {
    return [
        'character_name' => 'Jaina',
        'class_id' => 1,
        'race_id' => 1,
        'role' => 'damage',
    ];
});

$factory->state(App\Guild\Application::class, 'with_user', function (Faker $faker) {
    return [
        'user_id' => factory(App\Models\User::class)->create()
    ];
});
