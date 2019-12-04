<?php

use Illuminate\Database\Seeder;
use App\Models\Setup\AttendanceStatus;
class AttendenceStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendance_status = [
            ['id'=>'1', 'status' => 'On Time'],
            ['id'=>'2', 'status' => 'On Leave'],
            ['id'=>'3', 'status' => 'Late'],

	    ];

        AttendanceStatus::insert($attendance_status);
    }
}
