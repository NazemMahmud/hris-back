<?php

use App\Models\Setup\EmployeeLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmployeeLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee_levels = [
            ['id' => 1, 'job_level' => 'A', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'job_level' => 'B', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'job_level' => 'C', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        EmployeeLevel::insert($employee_levels);
    }
}
