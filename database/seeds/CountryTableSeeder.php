<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'id' => 1,
            'name' => 'Pakistan',
            'code' => 'Pak',
            'isActive' => 1,
            'isDefault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('countries')->insert([
            'id' => 2,
            'name' => 'Bangladesh',
            'code' => 'Ban',
            'isActive' => 1,
            'isDefault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('countries')->insert([
            'id' => 3,
            'name' => 'Canada',
            'code' => 'Can',
            'isActive' => 1,
            'isDefault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
