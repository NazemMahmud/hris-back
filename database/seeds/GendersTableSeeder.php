<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Setup\Gender;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Gender::truncate();

        $genders = [
            [
                'id' => 1,
                'name' => 'Male',
                'isActive' => 1,
                'isDefault' => 1,
                'code' => 'm',
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Female',
                'isActive' => 1,
                'isDefault' => 0,
                'code' => 'f',
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Others',
                'isActive' => 1,
                'isDefault' => 0,
                'code' => 'o',
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        Gender::insert($genders);
    }
}