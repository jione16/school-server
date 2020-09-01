<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Study;
use Faker\Generator as Faker;

$factory->define(Study::class, function (Faker $faker) {
    return [
        'student_id' => rand(1,30),
        'class_id' => rand(1,30),
        'is_active' => true,
    ];
});
