<?php

namespace App\Http\Controllers\Roster;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Base\BaseCollection;
use App\Models\Roster\EmployeeRosterModel;
use App\Models\Roster\RosterAttendance;
use App\Utility\Clock;
use Illuminate\Http\Request;

class RosterAttendanceController extends BaseController
{
    public function __construct(RosterAttendance $roster_attendance)
    {
        $this->EntityInstance = $roster_attendance;
        parent::__construct();
    }

    public function getRosterAttendance(Request $request) {
        $roster_attendance = RosterAttendance::join('employee_rosters', 'employee_rosters.id', '=', 'roster_attendance.eroster_id')
                    ->join('rosters', 'rosters.id', '=', 'employee_rosters.roster_id')->join('employees', 'employees.id', '=', 'roster_attendance.staff_id')
                    ->select('roster_attendance.id', 'rosters.name', 'employees.employeeName', 'roster_attendance.checkin_time', 'roster_attendance.checkout_time', 
                    'roster_attendance.date', 'roster_attendance.due_time', 'roster_attendance.over_time')->get();

        if (!empty(sizeof($roster_attendance))) {
            return new BaseCollection($roster_attendance);
        }
        return response()->json(['message' => 'Resource not found'], 404);
    }

    public function checkConflict(Request $request, $user_id) {
        $start_dtime = $request->start_dtime;
        if($user_id && $start_dtime) {
            $last_roster = EmployeeRosterModel::last_roster($user_id);
            if($last_roster) {
                $end_dtime = Clock::renderTimeStamp($last_roster->end_dtime);
                $start_dtime = Clock::renderTimeStamp($start_dtime);
                if($start_dtime < $end_dtime) {
                    return response()->json(['message' => 'This employee has already same configuration'], 409);
                } else {
                    return response()->json(['message' => 'success'], 200);
                }
            } else {
                return response()->json(['message' => 'success'], 200);
            }
        }
        return response()->json(['message' => 'Bad Request error'], 400);
    }
}
