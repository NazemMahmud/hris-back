<?php

namespace App\Http\Controllers\Travel;

use App\Enums\Approval\ApprovalStatusEnum;
use App\Enums\Approval\StatusEnum;
use App\Http\Controllers\BaseController;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\Travel\Travel;
use App\Models\Travel\TravelApprovalRequest;
use App\GenericSolution\GenericModels\CommonOperation\EmployeeGenericInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TravelApprovalController extends BaseController
{
    public function __construct(TravelApprovalRequest $approval)
    {
        $this->EntityInstance = $approval;
        parent::__construct();
    }

    public function getApprovedBy($level, $staffId) {
        if($level == 'first_line_manager') {
            return EmployeeGenericInfo::getFirstLineManagerId($staffId);
        } else if($level == 'second_line_manager') {
            return EmployeeGenericInfo::getSecondtLineManagerId($staffId);
        } else if($level == 'hrbp') {
            return EmployeeGenericInfo::getHrbpId($staffId);
        } else {
            return (int) $level;
        }
    }

    public function findNextLevel($levels, $current_level) {
        foreach($levels as $index => $level) {
            if($level->id == $current_level) {
                if(isset($levels[$index + 1]) && $levels[$index + 1]) {
                    return $levels[$index + 1];
                }
            }
        }
        return false;
    }

    public function TravelRequestApproved($travelId): void {
        $travel = Travel::where('id', $travelId)->first();
        $travel->status = ApprovalStatusEnum::Accepted()->getValue();
        $travel->save();
    }

    public function TravelRequestRejected($travelId): void {
        $rejectTravelRequest = Travel::where('id', '=', $travelId)->first();
        $rejectTravelRequest->status = ApprovalStatusEnum::Rejected()->getValue();
        $rejectTravelRequest->save();
    }

    public function approvalProccess(Request $request, $travelId) {
        $validator = Validator::make($request->all(), [
            'status'=> 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $status = $request->status;
        $staffId = $request->staff_id;
        
        if(!$this->EntityInstance->IsAuthorize($travelId, $staffId)) {
            return response()->json(['errors' => 'You are not Authorize']);
        }

        $levels = ApprovalFlowLevel::getApprovalLevels('Travel');
        $levels_depth = count($levels);
        $last_level = ($levels_depth - 1);
        $current_approve_level = $this->EntityInstance->getCurrentApproveLevel($travelId);
        $current_level = $current_approve_level->level_id;

        if($status == StatusEnum::Accepted()->getValue()) {
            if($current_level >= $levels[$last_level]->id) {
                $current_approve_level->status = StatusEnum::Accepted()->getValue();
                $current_approve_level->next_level = null;
                $current_approve_level->save();
                $this->TravelRequestApproved($travelId);
            } else {
                $next_level = $this->findNextLevel($levels, $current_level);

                if($next_level->level) {
                    $this->TravelRequestApproved($travelId);
                    $next_approval_level = new TravelApprovalRequest();
                    $next_approval_level->travel_id = $travelId;
                    $next_approval_level->level_id = $next_level->id;
                    $next_approval_level->approved_by = $this->getApprovedBy($next_level->level, $staffId);
                    $next_approval_level->status = StatusEnum::Pending()->getValue();
        
                    $next_next_approval_level = $this->findNextLevel($levels, $next_level->id);

                    if($next_next_approval_level) {
                        $next_approval_level->next_level = $next_next_approval_level->id;
                    } else {
                        $next_approval_level->next_level = null;
                    }

                    $next_approval_level->created_by = Auth::user()->id; 
                    $next_approval_level->updated_by = Auth::user()->id;
                    $next_approval_level->save();

                } else {
                    $this->TravelRequestApproved($travelId);
                }
            
                $current_approve_level->status = StatusEnum::Accepted()->getValue();
                $current_approve_level->next_level = isset($next_approval_level->id) ? $next_approval_level->id : null;
                $current_approve_level->save();
            }
        } else if($status == StatusEnum::Rejected()->getValue()) {
            $current_approve_level->status = StatusEnum::Rejected()->getValue();
            $current_approve_level->next_level = null;
            $current_approve_level->save();
            $this->TravelRequestRejected($travelId);

            return response()->json(['success' => 'Travel Rejected successfully']);
        }
        return response()->json(['success' => 'Travel approved successfully']);
    }
}
