<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'study_id' => rand(1,30),
        'amount' => rand(25,30),
        'month_pay'=>rand(1,3),
        'staff_id'=>rand(1,30),
    ];
});
