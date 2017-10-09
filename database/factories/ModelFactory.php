<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {

    $hasher = app()->make('hash');
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => $hasher->make("secret")
    ];
});

$factory->define(App\Models\Bucketlist::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->sentence(3),
        'user_id' => mt_rand(1, 3)
    ];
});

$factory->define(App\Models\Item::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->sentence(1),
        'user_id' => mt_rand(1, 3),
        'done' => $faker->boolean,
        'bucketlist_id' => mt_rand(1, 20)
    ];
});
