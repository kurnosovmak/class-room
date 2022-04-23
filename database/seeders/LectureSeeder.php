<?php

namespace Database\Seeders;

use App\Models\Lecture;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i=1;$i<10;$i++){
            Lecture::create([
                'theme'=>$faker->unique()->name,
                'description'=>$faker->realText,
            ]);
        }
    }
}
