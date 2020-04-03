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

$factory->define(App\Models\Rank::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'seniority' => $faker->numberBetween(5, 10),
    ];
});

$factory->state(App\Models\Rank::class, 'inner_circle', [
    'seniority' => 1,
]);
