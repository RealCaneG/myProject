<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Staff;
use Faker\Generator as Faker;

$factory->define(Staff::class, function (Faker $faker) {
    return [
        'id_team' => rand(0, 10),
        'id_office_hour_type' => rand(0,2),
        'staff_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //
    ];
});
