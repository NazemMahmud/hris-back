<?php

namespace App\Models\Overtime;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OvertimeApproval extends Model
{
    protected $table = "overtime_approval_requests";

    function storeResource($overTimeId)
    {
//        dd(Auth::user()->id);
        $firstLineManager = EmployeeInfo::select('lineManager_1st')->where('staff_id', Auth::user()->staff_id)->first();
        $date = Overtime::select('date')->where('id', $overTimeId)->first();
        $resource = new OvertimeApproval();
        $resource->overtime_request_id = $overTimeId;
        $resource->requested_user_id = Auth::user()->staff_id;
        $resource->user_level_id = $firstLineManager->lineManager_1st;
        $resource->status = 'Pending';
        $resource->save();
        $status = app('App\Models\Overtime\Overtime')->updateStatus($overTimeId, $resource->status);
        $basicInfo = app('App\Models\Overtime\Overtime')->overtimeBasicInfo(Auth::user()->staff_id);
        return [
            'status' => $resource->status,
            'totalOvertime' => $basicInfo['totalOvertime'],
            'totalClaimed' => $basicInfo['totalClaimed']
        ] ;
    }


    function setMssOvertimeList($overtime, $employeeName, $getOverTimeInfo){
        return [
            'id' => $overtime->id,
            'overtimeRequestId' => $overtime->overtime_request_id,
            'date' => date( 'Y-m-d', strtotime($getOverTimeInfo->date)),
            'employeeId' => $overtime->requested_user_id,
            'employeeName' => $employeeName,
            'totalWorkTime' => $getOverTimeInfo->total_work_time,
            'totalOvertime' => app('App\Models\Overtime\Overtime')->minuteToHourConvert($getOverTimeInfo->total_overtime),
            'status' => $overtime->status,
            'reason' => $overtime->reason,
            'created_at' => $overtime->created_at,
            'updated_at' => $overtime->updated_at,
            'isActive' => $overtime->isActive,
            'isDefault' => $overtime->isDefault,
        ];

    }
    function getMssOvertimeList($mssId){
        $overtimeLists = OvertimeApproval::where('user_level_id', $mssId)->orderBy('id', 'desc')->get();

        $getList = [];
        foreach ($overtimeLists as $overtime){
            $employee = Employee::find($overtime->requested_user_id);
            $getOverTimeInfo = Overtime::where('id',$overtime->overtime_request_id)->first();
            $getList [] = $this->setMssOvertimeList($overtime, $employee->employeeName, $getOverTimeInfo );
        }
        return $getList;
    }

    function getTotalAcceptedOvertimeThisMonth($requestedUserId){
        $acceptedOvertimes = Overtime::where('staff_id', $requestedUserId)->where('status', 2)->get();
        $overtimeCounter = 0;
        foreach ($acceptedOvertimes as $accepted){
            $overtimeCounter += $accepted->total_overtime;
        }
        return ($overtimeCounter <= 2880) ? true : false;
    }
    // get overtimeApprovalId &mssId &status
    // if overtime for this month more than 48 hours can't accept
    function overtimeAcceptance($request){
        $getOvertime = OvertimeApproval::find($request['overtimeApprovalId']);
        $checkOvertimeThisMonth = $this->getTotalAcceptedOvertimeThisMonth($getOvertime->requested_user_id);
        if($checkOvertimeThisMonth) {
            // overtime_approval_requests status change, updated_at update
            $getOvertime->status = ($request['status'] == 'accept') ? 'Accepted' : 'Rejected';
            $getOvertime->updated_at = date('Y-m-d');
            $getOvertime->reason = $request->reason;
            $getOvertime->save();
            // employee_overtimes status & updated_at will update
            app('App\Models\Overtime\Overtime')->updateStatus($getOvertime->overtime_request_id, $getOvertime->status);
        }
        return ['status' => $getOvertime->status ];
        // if more than 48 hours, another return statement needed
    }
}
