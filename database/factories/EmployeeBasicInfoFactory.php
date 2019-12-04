<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee\BasicInfo;
use App\Models\Employee\Employee;
use Faker\Generator as Faker;

$factory->define(BasicInfo::class, function (Faker $faker) {
    return [
        'staff_id' => $faker->randomDigitNotNull,//factory('App\Models\Employee\Employee')->create()->staff_id,
        'familyName' => $faker->name,
        'familyNameBangla' => $faker->name,
        'givenName'=> $faker->name,
        'givenNameBangla'=> $faker->name,
        'maritalStatusId'=> $faker->randomDigitNotNull,
        'dateofBirth'=> $faker->dateTime,
        'genderId'=> $faker->randomDigitNotNull,
        'nationalIdNumber'=> $faker->randomDigitNotNull,
        'countryId'=> $faker->randomDigitNotNull,
        'divisionId'=> $faker->randomDigitNotNull,
        'districtId'=> $faker->randomDigitNotNull,
        'maritalDate'=> $faker->dateTime,
        'languageId'=> $faker->randomDigitNotNull
    ];
});