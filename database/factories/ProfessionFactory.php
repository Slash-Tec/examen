<?php

use App\Profession;
use Faker\Generator as Faker;

$factory->define(Profession::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
    ];
});

$factory->afterCreating(Profession::class, function ($profession, $faker) {
    $skills = App\Skill::inRandomOrder()->take(rand(0, 3))->get();
    $profession->skills()->attach($skills);
});

