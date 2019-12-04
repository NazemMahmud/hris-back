<?php

use App\Models\Setup\EmployeeLocation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmployeeLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee_locations = [
            ['id' => 1, 'name' => 'Dhaka', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Khulna', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Rongpur', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        EmployeeLocation::insert($employee_locations);
    }
}
