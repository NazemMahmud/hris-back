<?php

namespace App\Models\Leave;

use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\ApprovalFlow\ApprovalFlowType;
use App\Models\Base;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeInfo;
use Illuminate\Support\Facades\Validator;


class LeaveApprovalRequests extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(),
        [
            'leaveRequestId' => 'required',
            'userLevelId' => 'required',
            'status' => 'required',
            'isDefault' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new LeaveApprovalRequests();

        $resource->leaveRequestId = $request->leaveRequestId;
        $resource->userLevelId = $request->userLevelId;
        $resource->status = $request->status;
        $resource->isDefault = $request->isDefault;
        $resource->isActive = $request->isActive;

        $resource->save();
        return $resource;
    }

    function storeLeaveApprovalRequest($leaveRequestId, $staffId)
    {
        $line_manager = EmployeeInfo::select('lineManager_1st')->where('staff_id', $staffId)->first();
        $mssName = Employee::where('id', $staffId)->pluck('employeeName')->first();
        $newLeaveApproval = new LeaveApprovalRequests();
        $newLeaveApproval->leaveRequestId = $leaveRequestId;
        $newLeaveApproval->userLevelId = $line_manager->lineManager_1st;
        $newLeaveApproval->status = 'Pending';
        $newLeaveApproval->save();

        return $mssName;
    }

    function storeBridgeLeaveApprovalRequest($leaveRequestId)
    {
        $flowType = ApprovalFlowType::where('name', 'like', '%Bridge%')->first();
        $flowLevel = ApprovalFlowLevel::where('approval_flow_type_id', $flowType->id)->first();
        $newLeaveApproval = new LeaveApprovalRequests();
//        `leave_approval_requests`(`leaveRequestId`, `userLevelId`, `status`, `isActive`, `isDefault`)
        $newLeaveApproval->leaveRequestId = $leaveRequestId;
        $newLeaveApproval->userLevelId = $flowLevel->level;
        $newLeaveApproval->status = 'Pending';
        $newLeaveApproval->save();
        return Employee::where('id', $flowLevel->level)->pluck('employeeName')->first();
    }

    function updateResource($request, $id)
    {
        $resource = LeaveApprovalRequests::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(),
        [
            'leaveRequestId' => 'required',
            'userLeaveId' => 'required',
            'status' => 'required',
            'isDefault' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->leaveRequestId = $request->leaveRequestId;
        $resource->userLeaveId = $request->userLeaveId;
        $resource->status = $request->status;
        $resource->isDefault = $request->isDefault;
        $resource->isActive = $request->isActive;

        $resource->save();
        return $resource;
    }

    function updateStatus($leaveApprovalRequest, $storeData){
        $leaveApprovalRequest->status = $storeData->status;
        $leaveApprovalRequest->next_level = $storeData->nextLevel;
        $leaveApprovalRequest->updated_at = date("Y-m-d H:i:s");
        $leaveApprovalRequest->save();
    }
}
