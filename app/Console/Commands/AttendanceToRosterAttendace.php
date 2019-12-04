<?php

namespace App\Console\Commands;

use App\Models\Employee\EmployeeAttendance;
use App\Models\Roster\EmployeeRosterModel;
use App\Models\Roster\RosterAttendance;
use App\Utility\Clock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AttendanceToRosterAttendace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roster:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Employee daily attendace to roster attendace calculation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $last_period_time = RosterAttendance::lastPeriod();
        $employee_attendace = EmployeeAttendance::where('created_at', '>', $last_period_time)->get();
        
        try {
            DB::beginTransaction();
            foreach($employee_attendace as $attendance) {
                $eCurrent_roster = EmployeeRosterModel::latestEmployeeRoster($attendance['staff_id']);
                //Cheking current employee is roster shift or not 
                if(!empty($eCurrent_roster)) {
                    $new_roster_attendance = new RosterAttendance();
                    $new_roster_attendance->staff_id = $attendance['staff_id'];
                    $new_roster_attendance->eroster_id = $eCurrent_roster->id;
                    $new_roster_attendance->checkin_time = $attendance['in_time'];
                    $new_roster_attendance->checkout_time = $attendance['out_time'];
                    $new_roster_attendance->date = $attendance['date'];

                    $roster_start_time = Clock::renderTimeStamp($eCurrent_roster['start_time']);
                    $roster_end_time = Clock::renderTimeStamp($eCurrent_roster['end_time']);
                    $attendace_checkin_time = Clock::renderTimeStamp($attendance['in_time']);
                    $attendace_checkout_time = Clock::renderTimeStamp($attendance['out_time']);
                    
                    $defualt_time = '00:00:00';
                    //is employee office enter lately or not 
                    if($attendace_checkin_time > $roster_start_time) {
                        $late_time = Clock::timeDiff($attendance['in_time'], $eCurrent_roster['start_time']);
                        $new_roster_attendance->due_time = $late_time;
                        //if employee going home early
                        if($attendace_checkout_time > $roster_end_time) {
                            $over_time = Clock::timeDiff($attendance['out_time'], $eCurrent_roster['end_time']);
                            if(Clock::renderTimeStamp($over_time) > Clock::renderTimeStamp($late_time)) {
                                $over_time = Clock::timeDiff($over_time, $late_time);
                            } else {
                                $over_time = $defualt_time;
                            }
                        } else {
                            $over_time = $defualt_time;
                            $after_late_time = Clock::timeDiff($eCurrent_roster['end_time'], $attendance['out_time']);
                            //after office start time late + after office time late
                            $late_time = Clock::sumTime([$late_time, $after_late_time]);
                        }
                    } else {
                        $over_time = Clock::timeDiff($eCurrent_roster['start_time'], $attendance['in_time']);
                        if($roster_end_time > $attendace_checkout_time) {
                            $late_time = Clock::timeDiff($eCurrent_roster['end_time'], $attendance['out_time']);
                            if(Clock::renderTimeStamp($over_time) < Clock::renderDateTime($late_time)) {
                                $over_time = $defualt_time;
                            }
                        } else {
                            $late_time = $defualt_time;
                            $after_over_time = Clock::timeDiff($attendance['out_time'], $eCurrent_roster['end_time']);
                            // before office start over time + after office over time 
                            $over_time = Clock::sumTime([$over_time, $after_over_time]);
                        }
                    }
                    $new_roster_attendance->due_time = $late_time;
                    $new_roster_attendance->over_time = $over_time;
                    $new_roster_attendance->save();
                }
            }
            DB::commit();
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
