<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'gender' => 'Male',
        'date_of_birth' => $faker->date,
        'place_of_birth' => $faker->address,
        'father_name' => $faker->name,
        'father_position' => $faker->jobTitle,
        'mother_name' => $faker->name,
        'mother_position' => $faker->jobTitle,
        'address' => $faker->address,
        'contact_number' => $faker->phoneNumber
    ];
});
