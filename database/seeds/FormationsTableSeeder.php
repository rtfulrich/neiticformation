<?php

use Illuminate\Database\Seeder;

class FormationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = ['développement web', 'call center', 'UI/UX design', 'multimédia'];
        for ($i = 0; $i < count($title); $i++) {
            DB::table('formations')->insert([
                'title' => $title[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
