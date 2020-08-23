<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'level' => rand(1,3),
        'language'=>'Khmer',
    ];
});
