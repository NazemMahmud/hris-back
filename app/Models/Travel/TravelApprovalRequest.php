<?php

namespace App\Models\Travel;

use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\Employee\Employee;
use App\Models\Base\BaseModel;

class TravelApprovalRequest extends BaseModel
{
    protected $table = "travel_approval_request";

    public function __construct() 
    {
        parent::__construct($this);
    }

//    public function getCurrentApproveLevel($travelId) {
//        $level = TravelApprovalRequest::where('travel_id', $travelId)->orderBy('id', 'desc')->first();
//        return $level;
//    }

    public function IsAuthorize($travelId, $staffId): bool {
        $approvalProcess = TravelApprovalRequest::where('travel_id', $travelId)
        ->select('approved_by')->orderBy('id', 'desc')->first();
        if(!empty($approvalProcess) && $approvalProcess->approved_by == $staffId) {
            return true;
        } else {
            return false;
        }
    }
}
