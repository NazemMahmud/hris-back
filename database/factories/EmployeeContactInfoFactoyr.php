<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmployeeContactInfo;
use Faker\Generator as Faker;

$factory->define(App\Models\Employee\EmployeeContactInfo::class, function (Faker $faker) {
    return [
        
        'staff_id' => $faker->randomDigitNotNull,
        'office_phone_no' => $faker->randomNumber,
        'home_phone_no' => $faker->randomNumber,
        'extension_no' => $faker->numberBetween($min =1, $max =12345),
        'personal_email' => $faker->email,
        'company_email' => $faker->email,
        'relation_name' => $faker->name,
        'second_contact_name' => $faker->name,
        'phone_no_01' => $faker->randomNumber,
        'phone_no_2' => $faker->randomNumber,
        'permanent_address' => $faker->address,
        'permanent_country' => $faker->city,
        'permanent_division' => $faker->city,
        'permanent_district' => $faker->city,
        'permanent_city' => $faker->city,
        'permanent_thana' => $faker->city,
        'present_address' => $faker->address,
        'present_country' => $faker->country,
        'present_division' => $faker->city,
        'present_district' => $faker->city,
        'present_thana' => $faker->city,
        'present_city' => $faker->city,
    ];
    
});