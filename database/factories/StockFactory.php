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

$factory->define(App\Guild\Bank\Stock::class, function (Faker $faker) {
    return [
        'banker_id' => factory(App\Guild\Bank\Banker::class)->make(),
        'bag' => $faker->numberBetween(-1, 11),
        'mail' => null,
        'slot' => $faker->numberBetween(0, 13),
        'item_id' => 4540,
        'count' => $faker->numberBetween(1, 20),
        'updated_by_user_id' => factory(App\Models\User::class)->make(),
    ];
});
