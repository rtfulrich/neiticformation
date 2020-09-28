<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teacher;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name(),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
