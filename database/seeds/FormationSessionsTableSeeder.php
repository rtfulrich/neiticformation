<?php

use App\Formation;
use App\Teacher;
use Illuminate\Database\Seeder;

class FormationSessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 1; $i < 12; $i++) {
            $last_id_of_f = DB::table('formation_sessions')->where('formation_id', Formation::all()->random()->get('id'))->max('session_number');
            if ($last_id_of_f != null) $session_number = $last_id_of_f + 1;
            else $session_number = 1;
            $date_debut = $faker->dateTimeBetween('-1 year', '+1 month');
            DB::table('formation_sessions')->insert([
                'formation_id' => Formation::all()->random()->get('id'),
                'session_number' => $session_number,
                'date_debut' => $date_debut ,
                'date_end' => $faker->dateTimeBetween($date_debut, '+6 months') ,
                'fee' => $faker->randomNumber(5) ,
                'description' => $faker->paragraphs(3) ,
                'teacher_id' => Teacher::all()->random()->get('id') ,
                'created_at' => now() ,
                'updated_at' => now()
            ]);
        }
    }
}
