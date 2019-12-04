<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Employee\Requisition;
use Illuminate\Http\Request;
use App\Models\Attendance\ManualAttendance;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\ApprovalFlow\ApprovalFlowType;
use App\Models\Attendance\ManualAttendanceApprovalRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\EmployeeInfo;
/**
 * Class PaymentTypeReposatory.
 */
class EmployeeManualAttendanceRepository
{
     public function __construct(ManualAttendanceApprovalRequest $manualAttendanceApprovalRequest)
    {
        $this->manualAttendanceApprovalRequest = $manualAttendanceApprovalRequest;

    }

    public function manualAttendanceAcceptance($request, $manualAttendanceId){

        $approvalflowData =  ManualAttendanceApprovalRequest::where('manualAttendanceId',$manualAttendanceId)->latest()->first();
        if($approvalflowData->next_level<8){

            $skipData = $approvalflowData->next_level - 1;
            $approvalflowstatus = $this->getNextLevel($skipData);

            if($approvalflowstatus->level !=null){
                if($request->status=='accepted'){
                    $approvalflowData->status = "accepted";
                    $approvalflowData->save();

                    //next level
                    $nextlevelOnFlow = $this->getNextLevel($approvalflowData->next_level);
                        //return $nextlevelOnFlow;
                        if($nextlevelOnFlow->level !=null){
                           
                            $manualattendance = ManualAttendance::where('id',$manualAttendanceId)->first();

                            // return $nextlevelOnFlow;
                            $nextLevelMssId = 0;
                            if($nextlevelOnFlow->level=='second_line_manager'){
                                $nextLevelMssId = EmployeeInfo::where('staff_id', $manualattendance->staff_id)->pluck('lineManager_2nd')->first();
                            }if($nextlevelOnFlow->level == 'hrbp'){
                                $nextLevelMssId = EmployeeInfo::where('staff_id', $manualattendance->staff_id)->pluck('hrbp')->first();
                            }
  
                            //has next level
                            $status = "pending";
                            $this->manualAttendanceApprovalRequest->storeNewRow($approvalflowData->manualAttendanceId,$status,
                            $approvalflowData->next_level,$nextLevelMssId);

                        }
                }if($request->status=='rejected'){
                        //rejected
                        $this->rejectedAttendance($approvalflowData,$manualAttendanceId);
                }
            }
            $approvalflowData->status = "accepted";
            $approvalflowData->save();
           
        }
        $this->requestAcceptBasisOnAcceptance($manualAttendanceId);
        
        //accept or reject mail
        return "pass";
    }

    public function rejectedAttendance($approvalflowData,$manualAttendanceId){
        $approvalflowData->status = "rejected";
        $approvalflowData->save();
        $manualattendance = ManualAttendance::where('id',$manualAttendanceId)->first();
        $manualattendance->status = 2;
        $manualattendance->save();
    }

    public function requestAcceptBasisOnAcceptance($manualAttendanceId){

        $manualattendencestatusData = ApprovalFlowType::select('approval_flow_levels.level')
                                ->join('approval_flow_levels', 'approval_flow_types.id', '=', 'approval_flow_levels.approval_flow_type_id')
                                ->where('approval_flow_types.name','Manual Attendance')
                                ->where('approval_flow_levels.level','!=',"null")
                                ->get();

        $countManualAttendence = count($manualattendencestatusData); 
        $manualattendenceRequestData = ManualAttendanceApprovalRequest::where('manualAttendanceId',$manualAttendanceId)->get();
        $acceptedRequestCount = 0;
        foreach($manualattendenceRequestData as $manualattendenceRequest){
            if($manualattendenceRequest->status=="accepted"){
                ++$acceptedRequestCount;
            }
        }
        if($countManualAttendence == $acceptedRequestCount){
            $manualattendance = ManualAttendance::where('id',$manualAttendanceId)->first();
            $manualattendance->status = 1;
            $manualattendance->save();
        }

    }

    public function getNextLevel($skipData){
         return ApprovalFlowType::select('approval_flow_levels.level')
                                    ->join('approval_flow_levels', 'approval_flow_types.id', '=', 'approval_flow_levels.approval_flow_type_id')
                                    ->where('approval_flow_types.name','Manual Attendance')
                                    ->skip($skipData)
                                    ->first(); 
    }

}
