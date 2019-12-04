<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Employee\EmployeeAttendance;
use App\Models\Employee\EmployeeInfo;
use App\Models\Setup\AttendenceTest;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\Roster\EmployeeRosterModel;
use App\Models\Roster\RosterModel;
use App\Models\ShiftType\ShiftType;
use App\Http\Resources\Attendance\AttendanceCollection;
use Illuminate\Support\Facades\Input;
use App\Http\Resources\Attendance\Attendance;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use function Composer\Autoload\includeFile;

class AttendanceController extends Controller
{

    public function changeEmployeeAttendanceStatus()
    {
        $employeeAttendances = EmployeeAttendance::all();
        foreach ($employeeAttendances as $employeeAttendance) {
            $EmployeeInfo = EmployeeInfo::where('employee_info.staff_id', $employeeAttendance->staff_id)
                ->join('shift_types', 'employee_info.shiftType_id', '=', 'shift_types.id')
                ->select('shift_types.startTime')->first();

            $employeeAttendanceData = EmployeeAttendance::find($employeeAttendance->id);

            if ($employeeAttendance->in_time > $EmployeeInfo->startTime) {
                $employeeAttendanceData->attendance_status = "3";
            } else {
                $employeeAttendanceData->attendance_status = "1";
            }

            $employeeAttendanceData->save();
        }
        return response()->json(['data' => 'saved'], 500);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AttendanceCollection
     */
    public function checkEmployeeAttendance(Request $request){
        $date=null;
        $staff_id =null;
        if (!empty($request->date)) {
            $date = Helper::formatdate($request->date);
        }
        if (!empty($request->staff_id)) {
            $staff_id = $request->staff_id;
        }
        
        $resource = EmployeeAttendance::where('staff_id',$staff_id )->whereDate('date',$date)->first();
        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);
        return new Attendance($resource);
    }

    public function index(Request $request)
    {
        $shiftType = $request->shift_id;
        $location = $request->location_id;
        $division = $request->division_id;
        $department = $request->department_id;
        $attendanceStatusId = $request->attendance_status_id;

        $date_from = null;
        if (!empty($request->date_from)) {
            $date_from = Helper::formatdate($request->date_from);
        }
        $date_to = null;
        if (!empty($request->date_to)) {
            $date_to = Helper::formatdate($request->date_to);
        }

        $datas['data'] = [];

        if (!empty($location) || $location != 'null' || !empty($shiftType) || $shiftType != 'null' || !empty($division) || $division != 'null'
            || !empty($department || $department != 'null' || ($date_from != 'null') || ($date_from != null) || ($date_to != null) || ($date_to != 'null') || !empty($attendanceStatusId) || $attendanceStatusId != 'null')) {
            $employeeAttendance = new EmployeeAttendance();
            $employeeAttendance = $employeeAttendance->select('employee_attendance.*');
        }
        if (!empty($location) || !empty($shiftType) || !empty($division) || !empty($department)) {
            $employeeAttendance = $employeeAttendance->Join('employee_info', 'employee_info.staff_id', '=', 'employee_attendance.staff_id');
        }
        if (!empty($location) && $location != 'null') {
            $employeeAttendance = $employeeAttendance->where(['employee_info.location_id' => $location]);
        }
        if (!empty($shiftType) && $shiftType != 'null') {
            $employeeAttendance = $employeeAttendance->where(['employee_info.shiftType_id' => $shiftType]);
        }
        if (!empty($division) && $division != 'null') {
            $employeeAttendance = $employeeAttendance->where(['employee_info.org_division_id' => $division]);

        }
        if (!empty($department) && $department != 'null') {
            $employeeAttendance = $employeeAttendance->where(['employee_info.org_department_id' => $department]);
        }

        if (!empty($date_from) && $date_from != 'null' && !empty($date_to) && $date_to != 'null') {
            $employeeAttendance = $employeeAttendance->whereBetween('employee_attendance.date', [$date_from, $date_to]);
        }
        if ((!empty($date_from) && $date_from != 'null') && (empty($date_to) || $date_to == 'null')) {
            $date_to = Carbon::now();
            $date_to = Helper::formatdate($date_to);
            $employeeAttendance = $employeeAttendance->whereBetween('employee_attendance.date', [$date_from, $date_to]);
        }
        if ((empty($date_from) || $date_from == 'null') && (!empty($date_to)  && $date_to != 'null')) {
            $date_from = '1919-10-22';

            $employeeAttendance = $employeeAttendance->whereBetween('employee_attendance.date',[$date_from, $date_to]);
        }

        if (!empty($attendanceStatusId) && $attendanceStatusId != 'null') {
            $employeeAttendance = $employeeAttendance->where(['employee_attendance.attendance_status' => $attendanceStatusId]);
        }


        if (!empty($location) || $location != 'null' || !empty($shiftType) || $shiftType1 = 'null' || !empty($division) || $division != 'null'
                || !empty($department || $department != 'null' || ($date_from != 'null') || ($date_from != null) || ($date_to != 'null')
                    || ($date_to != null)  || !empty($attendanceStatusId) || $attendanceStatusId != 'null')) {

            $employeeAttendance = $employeeAttendance->orderBy('employee_attendance.id', 'DESC');
            $employeeAttendance = $employeeAttendance->paginate(100);
            $datas['data'] = $employeeAttendance;
        };


        if ((empty($location) || $location == 'null') && (empty($shiftType) || $shiftType == 'null') && (empty($division) || $division == 'null')
            && ((empty($department) || $department == 'null') && ($date_to == null || $date_to == 'null')
                && ($date_from == null || $date_from == 'null') && (empty($attendanceStatusId) || $attendanceStatusId == 'null'))
        ) {
            $datas['data'] = EmployeeAttendance::orderBy('id', 'DESC')->paginate(100);
        }

        foreach ($datas['data'] as $data['data']) {
            $data['data']['shift_data'] = '';
            $employeeInfo = EmployeeInfo::where('staff_id', $data['data']['staff_id'])->select('shiftType_id')->first();
            if ($employeeInfo) {
                $shiftData = ShiftType::where('id', $employeeInfo->shiftType_id)->select('name')->first();
                $data['data']['shift_name'] = $shiftData->name ? $shiftData->name : '';
            } else {
                $data['data']['shift_name'] = '';
            }
        }

        return new AttendanceCollection($datas['data']);
    }

    public function store(Request $request)
    {
        $users = User::all();

        foreach ($users as $user) {
            $current_date = date("Y-m-d");
            $in_time = AttendenceTest::where('pin', $user->staff_id)->whereDate('event_time', '=', Carbon::parse($current_date)->format('Y-m-d'))->first();
            $out_time = AttendenceTest::where('pin', $user->staff_id)->whereDate('event_time', '=', Carbon::parse($current_date)->format('Y-m-d'))->latest('event_time')->first();

            $employee_attendance_old = EmployeeAttendance::whereDate('date', '=', Carbon::parse($current_date)->format('Y-m-d'))->where('staff_id', $user->staff_id)->first();

            if ($employee_attendance_old) {
                $employee_attendance_old->date = $current_date;
                $employee_attendance_old->staff_id = $user->staff_id;
                $employee_attendance_old->in_time = $in_time->event_time;
                $employee_attendance_old->out_time = $out_time->event_time;
                $StatusAndOvertime = $this->CheckStatusAndOvertime($user, $out_time, $in_time);
                $employee_attendance_old->attendance_status = $StatusAndOvertime[0];
                $employee_attendance_old->overtime = $StatusAndOvertime[1];
                $employee_attendance_old->save();
            } else {
                $employee_attendance = new EmployeeAttendance;
                $employee_attendance->date = $current_date;
                $employee_attendance->staff_id = $user->staff_id;
                $employee_attendance->in_time = $in_time->event_time;
                $employee_attendance->out_time = $out_time->event_time;
                $StatusAndOvertime = $this->CheckStatusAndOvertime($user, $out_time, $in_time);
                $employee_attendance_old->attendance_status = $StatusAndOvertime[0];
                $employee_attendance_old->overtime = $StatusAndOvertime[1];
                $employee_attendance->save();
            }
        }
        return EmployeeAttendance::whereDate('date', '=', Carbon::parse($current_date)->format('Y-m-d'))->get();
    }

    public function getTeamAttendance($first_line_manager_id)
    {
        $employees = EmployeeInfo::where('lineManager_1st', $first_line_manager_id)->get();

        $team_attendance = [];

        foreach ($employees as $employee) {
            $employee_attendances = EmployeeAttendance::where('staff_id', $employee->staff_id)->get();

            if (count($employee_attendances) > 0) {
                array_push($team_attendance, ...$employee_attendances);
            }
        }

        return $team_attendance;
    }

    public function CheckStatusAndOvertime($user, $out_time, $in_time)
    {
        $statusAnsOvertime = [];
        $employeeInRoaster = EmployeeRosterModel::where('staff_id', $user->staff_id)->select('roster_id')->first();
        $EmployeeInTime = new Carbon($out_time->event_time);
        $EmployeeOutTime = new Carbon($in_time->event_time);
        if (!empty($employeeInRoaster)) {
            $roster = RosterModel::where('id', $employeeInRoaster->roster_id)->select('start_time', 'end_time')->first();
            if (!empty($roster)) {
                $shiftStartTime = new Carbon($roster->start_time);
                $startTimeDifferent = $shiftStartTime->diff($EmployeeInTime)->format('%H:%I');
                $startTimeDifferent = explode(":", $startTimeDifferent);
                $shiftEndTime = new Carbon($roster->end_time);
                $employeeOutDifferent = $shiftEndTime->diff($EmployeeOutTime)->format('%H:%I');
            }
        } else {
            $EmployeeOnShift = EmployeeInfo::where('shiftType_id', $user->staff_id)->select('shiftType_id')->first();
            $ShiftType = ShiftType::where('id', $EmployeeOnShift->shiftType_id)->select('startTime', 'endTime')->first();
            if (!empty($ShiftType)) {
                $shiftStartTime = new Carbon($ShiftType->startTime);
                $startTimeDifferent = $shiftStartTime->diff($EmployeeInTime)->format('%H:%I');
                $startTimeDifferent = explode(":", $startTimeDifferent);
                $shiftEndTime = new Carbon($ShiftType->endTime);
                $employeeOutDifferent = $shiftEndTime->diff($EmployeeOutTime)->format('%H:%I');
            }
        }
        if (($startTimeDifferent[0] > 1 || ($startTimeDifferent[1] > 1)) && $startTimeDifferent[0] < 5) {
            array_push($statusAnsOvertime, "Overtime");
        } else {
            array_push($statusAnsOvertime, "Ontime");
        }
        array_push($statusAnsOvertime, "overtime");
        return $statusAnsOvertime;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */

    public function show($id)
    {
        return EmployeeAttendance::where('staff_id', $id)->get();
    }

    public function currentDateAttendance($id)
    {
        return EmployeeAttendance::whereDate('date', '=', Carbon::today())->where('staff_id', $id)->get();
    }

    public function manualAttendance(Request $request, $id)
    {
        $employee_attendance_old = EmployeeAttendance::whereDate('date', '=', Carbon::today())->where('staff_id', 10000071)->first();

        if ($employee_attendance_old) {
            $employee_attendance_old->date = Carbon::today();
            $employee_attendance_old->staff_id = $id;
            $employee_attendance_old->in_time = $request->in_time;
            $employee_attendance_old->out_time = $request->out_time;

            $employee_attendance_old->save();
            return $employee_attendance_old;
        } else {
            $employee_attendance = new EmployeeAttendance;

            $employee_attendance->date = Carbon::today();
            $employee_attendance->staff_id = $id;
            $employee_attendance->in_time = $request->in_time;
            $employee_attendance->out_time = $request->out_time;

            $employee_attendance->save();
            return $employee_attendance;
        }
    }
}
