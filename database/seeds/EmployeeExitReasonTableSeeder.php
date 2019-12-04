<?php

use App\Models\Setup\EmployeeExitReason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmployeeExitReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee_exit_reasons = [
            ['id' => 1, 'reason' => 'Sick', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'reason' => 'Maternity-Leave', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'reason' => 'Sick', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        EmployeeExitReason::insert($employee_exit_reasons);
    }
}
