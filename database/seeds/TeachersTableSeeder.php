<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            DB::table('teachers')->insert([
                'full_name' => $faker->firstName . ' ' .$faker->lastName,
                'email' => $faker->safeEmail,
                'phone' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
