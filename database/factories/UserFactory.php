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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(1000000, 99999999),
        'nickname' => $faker->firstNameMale,
        'email' => $faker->email,
        'battletag' => $faker->regexify('[a-z]{5,8}#\d{4}'),
        'rank_id' => factory(App\Guild\Rank::class)->create(),
    ];
});

$factory->state(App\User::class, 'commander', function (Faker $faker) {
    return [
        'rank_id' => factory(App\Guild\Rank::class)->states('commander')->create(),
    ];
});


$factory->state(App\User::class, 'inner_circle', function (Faker $faker) {
    return [
        'rank_id' => factory(App\Guild\Rank::class)->states('inner_circle')->create(),
    ];
});
