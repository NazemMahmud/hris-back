<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmployeeUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_units')->insert([
            'id' => 1,
            'name' => 'Financial Accounting',
            'division_id' => '2',
            'department_id' => '3',
            'isActive' => 1,
            'isDefault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('employee_units')->insert([
            'id' => 2,
            'name' => 'Energy Management',
            'division_id' => '2',
            'department_id' => '3',
            'isActive' => 1,
            'isDefault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('employee_units')->insert([
            'id' => 3,
            'name' => 'Business Process Management',
            'division_id' => '4',
            'department_id' => '3',
            'isActive' => 1,
            'isDefault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
