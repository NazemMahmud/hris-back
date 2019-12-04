<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Setup\BloodGroup;


class BloodGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blood_groups = [
            ['id' => 1, 'name' => 'A+', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'A-', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'AB+', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'AB-', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'O-', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'O+', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];
        BloodGroup::insert($blood_groups);
    }
}
