<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Employee\Employee::class, function (Faker $faker) {
    return [
        // 'id' => $faker->id,
        'employeeName' => $faker->name
    ];
});
