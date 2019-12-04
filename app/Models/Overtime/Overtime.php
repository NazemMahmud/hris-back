<?php

namespace App\Models\Overtime;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeAttendance;
use App\Models\Employee\EmployeeInfo;
use App\Models\ShiftType\ShiftType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Overtime extends Model
{
    protected $table = "employee_overtimes";

    /**
     * @param $totalOvertime
     * @return string
     */
    function minuteToHourConvert($totalOvertime)
    {
        $hour = intval($totalOvertime / 60);
        $minute = $totalOvertime % 60;
        $min = ($minute) ? $minute." min." : '';
        return (!$hour) ? $min : $hour . " hr. " . $min;
    }

    function calculateOvertime($attendance, $inOutTime )
    {
        $overtime = 0;
        if ($attendance->in_time < $inOutTime->startTime)
            $overtime +=  (strtotime($inOutTime->startTime) - strtotime($attendance->in_time)) / 60;
        if ($attendance->out_time > $inOutTime->endTime)
            $overtime +=  (strtotime($attendance->out_time) - strtotime($inOutTime->endTime)) / 60;

        return ($overtime >= 60) ? $overtime : 0;
    }

    // if full-time && more than one hour
    function checkFullTime($attendance)
    {
        $shiftType = EmployeeInfo::select('shiftType_id')->where('staff_id',  $attendance->staff_id )->first();
        $inOutTime = ShiftType::select('startTime', 'endTime')->where('id', $shiftType->shiftType_id )->first();
        $totalWorkTime = (strtotime($attendance->out_time) - strtotime($attendance->in_time)) / 60 >= 510 ? true : false; /* 8.5 hours = 510 minutes */
        $timeCounter = 0;
        if($totalWorkTime){
            $timeCounter +=  $this->calculateOvertime($attendance, $inOutTime);
        }
        return $timeCounter;
    }

    /**
     * @param $attendance
     * @param $timeCounter
     */
    function storeResource($attendance, $timeCounter)
    {
        $totalWorkTime = $this->minuteToHourConvert((strtotime($attendance->out_time) - strtotime($attendance->in_time)) / 60);
        $resource = new Overtime();
        $resource->staff_id = $attendance->staff_id;
        $resource->date = $attendance->date;
        $resource->total_work_time = $totalWorkTime;
        $resource->total_overtime = $timeCounter;
        $resource->save();
    }

    function updateResource($attendance, $overtimeId, $timeCounter)
    {
        $totalWorkTime = $this->minuteToHourConvert((strtotime($attendance->out_time) - strtotime($attendance->in_time)) / 60);
        $resource = Overtime::find($overtimeId);
        $resource->total_work_time = $totalWorkTime;
        $resource->total_overtime = $timeCounter;
        $resource->updated_at = date('Y-m-d H:i:s');
        $resource->save();
    }

    function bandCheck($attendance){
        $isBand = Employee::select('band_id')->where('staff_id', $attendance->staff_id)->first();
        if($isBand->band_id == 8){
            $checkOverTimeExistToday = DB::table('employee_overtimes')->where('staff_id', $attendance->staff_id)
                ->whereDate('created_at', date('Y-m-d'))->first();
            // if fulltime && more than one hour
            $timeCounter = $this->checkFullTime($attendance);

            if ($timeCounter && empty($checkOverTimeExistToday) )
                $this->storeResource($attendance, $timeCounter);
            elseif ($timeCounter && !empty($checkOverTimeExistToday))
                $this->updateResource($attendance, $checkOverTimeExistToday->id, $timeCounter);
        }
    }
    // 1. check full time 8.5 hours --> $checkTimeDifference
    // 2. check if exists today(for scheduler)
    // // 2.1. if exists today UPDATE table
    // // 2.2. if NOT exists today, INSERT table
    function storeOrUpdateResource()
    {
        $attendanceLists = EmployeeAttendance::whereDate('created_at', Carbon::today())->get();
        foreach ($attendanceLists as $attendance) {
            $this->bandCheck($attendance);
        }
        $overtimes = Overtime::whereDate('created_at', date('Y-m-d'))->get();
        return $overtimes;
    }

    /**
     * @param $id
     * @return array
     */
    function getEmployeeOvertimeInfoById($id)
    {
        $overtimes = Overtime::where('staff_id', $id)->orderBy('id', 'DESC')->get();
        $overtime = [];
        foreach ($overtimes as $resource) {
            $totalOvertime = $this->minuteToHourConvert($resource->total_overtime);
            $status = (!$resource->status) ? 'Not Requested' : (($resource->status === 1) ? 'Pending' : (($resource->status === 2) ? 'Accepted' : 'Rejected'));
            $overtime[] = [
                'id' => $resource->id,
                'staff_id' => $resource->staff_id,
                'totalOvertime' => $totalOvertime,
                'status' => $status,
                'date' => date('Y-m-d', strtotime($resource->created_at)),
                'errorMessage' => ''
            ];
        }
        return $overtime;
    }

    function updateStatus($overtimeId, $status)
    {
        $resource = Overtime::find($overtimeId);
        $resource->status = ($status == 'Pending') ? 1 : (($status == 'Accepted') ? 2 : 3);
        $resource->updated_at = date('Y-m-d');
        $resource->save();
        return $resource->status;
    }

    function calculateOvertimeOfThisMonth($overtimeOrClaimed, $staffId, $month){
        $overtimes = ($overtimeOrClaimed == 'overtime') ? Overtime::where('staff_id', $staffId)->whereMonth('date', $month)->get():
            Overtime::where('staff_id', $staffId)->whereMonth('date', $month)->where('status', '>=', 1)->get();
        $totalOvertimes = 0;
        foreach ($overtimes as $overtime){
            $totalOvertimes += $overtime->total_overtime;
        }
        return[
           'text' => $this->minuteToHourConvert($totalOvertimes),
           'number' => $totalOvertimes
        ];
    }


    function overtimeBasicInfo($staffId){
        // total overtime
        $month = date('m');
        $totalOvertimes = $this->calculateOvertimeOfThisMonth('overtime', $staffId, $month);
        $totalClaimed = $this->calculateOvertimeOfThisMonth('claimed', $staffId, $month);
        return [
            'totalOvertime' => $totalOvertimes['text'],
            'totalClaimed' => $totalClaimed['text'],
            'totalClaim' => $totalClaimed['number']
            ];
    }
}
