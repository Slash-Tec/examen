<?php

use App\Profession;
use App\Skill;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create([
            'title' => 'Desarrollador Back-End'
        ]);
        Profession::create([
            'title' => 'Desarrollador Front-End'
        ]);
        Profession::create([
            'title' => 'Diseñador web'
        ]);

        factory(Profession::class, 97)->create()->each(function ($profession) {
            $skills = Skill::inRandomOrder()->take(rand(0, 3))->pluck('id')->toArray();
            $profession->skills()->attach($skills);
        });
    }
}
