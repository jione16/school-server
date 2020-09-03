<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grade;
use Faker\Generator as Faker;

$factory->define(Grade::class, function (Faker $faker) {
    return [
            'sub_study_id'=>rand(1,30),
            'exam_date'=>$faker->date,
            'quiz_score'=>rand(0,20),
            'exam_score'=>rand(0,50),
            'homework_score'=>rand(0,10),
            'attendent_score'=>rand(0,10),
            'total_score'=>rand(0,100)
    ];
});
