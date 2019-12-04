<?php

use Illuminate\Database\Seeder;
use App\Models\Leave\LeaveType;

class LeaveTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leave_types = [
            ['name' => 'Annual Leave', 'maximumdays' => 26, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Sick Leave', 'maximumdays' => 14, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Maternaity Leave', 'maximumdays' => 182, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Paternaity Leave', 'maximumdays' => 5, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Compassionate Leave', 'maximumdays' => 3, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Pilgrim Leave', 'maximumdays' => 20, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Quarantine Leave', 'maximumdays' => 15, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0],
            ['name' => 'Transit Leave', 'maximumdays' => 5, 'carryForwardDayAnnually' => 0, 'includedWithAnnualLeave' => 0]
        ];

        LeaveType::insert($leave_types);
    }

}
