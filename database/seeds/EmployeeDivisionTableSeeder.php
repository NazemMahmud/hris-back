<?php

use App\Models\Setup\EmployeeDivision;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmployeeDivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee_divisions = [
            ['id' => 1, 'name' => 'Finance', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Production', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Supply', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        EmployeeDivision::insert($employee_divisions);
    }
}
