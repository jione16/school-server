<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Staff;
use Faker\Generator as Faker;

$factory->define(Staff::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'gender' => 'male',
        'nationality' => $faker->country,
        'foreign_language_level' => $faker->country,
        'genaral_knowledge_level' => $faker->country,
        'date_of_birth' => $faker->date,
        'place_of_birth' => $faker->address,
        'address' => $faker->address,
        'contact_number' => $faker->phoneNumber,
        'remark' => $faker->address
    ];
});
