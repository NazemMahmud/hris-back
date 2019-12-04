<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\Travel\TravelInvoiceApproval;
use Illuminate\Support\Facades\Validator;
use App\Enums\Approval\StatusEnum;
use App\Models\Travel\TravelInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelInvoiceApprovalController extends BaseController
{
    public function __construct(TravelInvoiceApproval $approval)
    {
        $this->EntityInstance = $approval;
        parent::__construct(); 
    }

    public function approvalProccess(Request $request, $travelInvoceId) {
        $validator = Validator::make($request->all(), [
            'status'=> 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $status = $request->status;
        $staffId = $request->staff_id;
        
        if(!$this->EntityInstance->isApprovalAuthorize(['travel_invoice_id', $travelInvoceId], $staffId)) {
            return response()->json(['errors' => 'You are not Authorize']);
        }

        $levels = ApprovalFlowLevel::getApprovalLevels('Travel invoice');
        $levels_depth = count($levels);
        $last_level = ($levels_depth - 1);
        $current_approve_level = $this->EntityInstance->getCurrentApproveLevel('travel_invoice_id', $travelInvoceId);
        $current_level = $current_approve_level->current_level;

        if($status == StatusEnum::Accepted()->getValue()) {
            if($current_level >= $levels[$last_level]->id) {

                $current_approve_level->status = StatusEnum::Accepted()->getValue();
                $current_approve_level->next_level = null;
                $current_approve_level->save();
                $this->EntityInstance->ParentRequestApproved(new TravelInvoice, $travelInvoceId);
            } else {

                $next_level = $this->EntityInstance->findNextLevel($levels, $current_level);

                if($next_level->level) {

                    $this->EntityInstance->ParentRequestApproved(new TravelInvoice, $travelInvoceId);
                    $next_approval_level = new TravelInvoiceApproval();
                    $next_approval_level->travel_id = $current_approve_level->travel_id;
                    $next_approval_level->travel_invoice_id = $travelInvoceId;
                    $next_approval_level->previous_level = $current_level;
                    $next_approval_level->current_level = $next_level->id;

                    $next_next_approval_level = $this->EntityInstance->findNextLevel($levels, $next_level->id);
                    if($next_next_approval_level) {
                        $next_approval_level->next_level = $next_next_approval_level->id;
                    } else {
                        $next_approval_level->next_level = null;
                    }

                    $next_approval_level->approved_by = $this->EntityInstance->getApprovedBy($next_level->level, $staffId);
                    $next_approval_level->status = StatusEnum::Pending()->getValue();

                    $next_approval_level->created_by = Auth::user()->id; 
                    $next_approval_level->updated_by = Auth::user()->id;
                    $next_approval_level->save();

                } else {
                    $this->EntityInstance->ParentRequestApproved(new TravelInvoice, $travelInvoceId);
                }
            
                $current_approve_level->status = StatusEnum::Accepted()->getValue();
                $current_approve_level->next_level = isset($next_approval_level->id) ? $next_approval_level->id : null;
                $current_approve_level->save();
            }
        } else if($status == StatusEnum::Rejected()->getValue()) {
            $current_approve_level->status = StatusEnum::Rejected()->getValue();
            $current_approve_level->next_level = null;
            $current_approve_level->save();
            $this->EntityInstance->ParentRequestRejected(new TravelInvoice, $travelInvoceId);

            return response()->json(['success' => 'Travel Invoice Rejected successfully']);
        }
        return response()->json(['success' => 'Travel Invoice approved successfully']);
    }

}
