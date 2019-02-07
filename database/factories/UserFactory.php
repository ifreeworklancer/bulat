<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
		'phone' => $faker->phoneNumber,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});
