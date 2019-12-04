<?php

use App\Models\Setup\EmployeeDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmployeeDepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee_departments = [
            ['id' => 1, 'division_id' => 2, 'name' => 'IT Audit', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'division_id' => 5, 'name' => 'Networking', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'division_id' => 8, 'name' => 'Digital Ventures', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        EmployeeDepartment::insert($employee_departments);
    }
}
