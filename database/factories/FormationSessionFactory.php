<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(App\FormationSession::class, function (Faker $faker) {
    $date = $faker->date();
    $dateDebutMin = $faker->dateTimeBetween('now', '+1 month');
    $toBeReturned = [
        'formation_id' => App\Formation::all()->random(),
        'session_number' => $faker->randomNumber(),
        'date_debut' => $dateDebutMin,
        'date_end' => $faker->dateTimeBetween($dateDebutMin, '+7 months'),
        'fee' => $faker->numberBetween(10000, 150000),
        'description' => $faker->paragraphs(3),
        'teacher_id' => App\Teacher::all()->random(),
        'created_at' => $date,
        'updated_at' => $date
    ];
    return $toBeReturned;
});
