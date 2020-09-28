<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Formation;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Formation::class, function (Faker $faker) {
    return [
        'title' => str_shuffle('skldjfameijlqjd'),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
