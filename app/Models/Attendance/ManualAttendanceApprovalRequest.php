<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\EmployeeInfo;

class ManualAttendanceApprovalRequest extends Model
{
    public function manualAttendanceStore($manualAttendanceId,$staff_id){

        $manualAtttendenceRequest = new ManualAttendanceApprovalRequest();
        $manualAtttendenceRequest->manualAttendanceId = $manualAttendanceId;
        
        $manualAtttendenceRequest->userLevelId = EmployeeInfo::select('lineManager_1st')->where('staff_id',$staff_id)->first()?
                                                EmployeeInfo::select('lineManager_1st')->where('staff_id',$staff_id)->first()->lineManager_1st:0;
        $manualAtttendenceRequest->next_level = 1;
        $manualAtttendenceRequest->status = "pending";
        $manualAtttendenceRequest->save();
        
    }
    public function storeNewRow($manualAttendanceId,$status,$next_level,$nextLevelMssId){
        $nextLevel = new ManualAttendanceApprovalRequest();
        $nextLevel->manualAttendanceId = $manualAttendanceId;
        $nextLevel->status = $status;
        $nextLevel->next_level = $next_level + 1;
        $nextLevel->userLevelId = $nextLevelMssId;
        $nextLevel->save();

    }
}
