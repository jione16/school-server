<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Classes;
use Faker\Generator as Faker;

$factory->define(Classes::class, function (Faker $faker) {
    return [
        //
        'staff_id' => rand(1, 30),
        'book_id' => rand(1, 30),
        'room_id' => rand(1, 30),
        'study_time' => rand(1, 3),
        'start_date' => $faker->date,
        'end_date' => $faker->date,
        'price' => rand(80, 120),
    ];
});
