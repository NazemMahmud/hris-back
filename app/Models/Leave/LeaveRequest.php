<?php

namespace App\Models\Leave;

use App\Helpers\FileuploadHelpers;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\ApprovalFlow\ApprovalFlowType;
use App\Models\Employee\BasicInfo;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeInfo;
use App\Models\Setup\LeaveType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
Use Datetime;
use Illuminate\Support\Facades\Validator;
use Helper;
use Illuminate\Support\Facades\Auth;

class LeaveRequest extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

//    function storeBridgeLeaveApprovalRequest($resource->id, Auth::user()->staff_id, $request->bridgeLeaveStatus){


    function storeResource($request)
    {
        $datetime1 = date("Y-m-d H:i:s", strtotime($request->date_From));
        $datetime2 = date("Y-m-d H:i:s", strtotime($request->date_To));
        /* $time_From = $request->has('time_From')?$request->time_From:null;
         $time_To = $request->has('time_To')?$request->time_To:null; */

        $resource = new LeaveRequest();;
        $resource->leave_type_id = $request->leaveTypeId;
        $resource->staff_id = Auth::user()->staff_id;
        $resource->date_From = $datetime1;
        $resource->date_To = $datetime2;
        $resource->time_From = $request->time_From;
        $resource->time_To = $request->time_To;
        $resource->totalDurationDays = $request->totalDurationDays;
        $resource->delegatee = $request->delegatee;
        $resource->isBridge = (isset($request->bridgeLeaveStatus) && $request->bridgeLeaveStatus <= 1) ? 1 : 0;
        $resource->reason = $request->reason;
        $resource->requestStatus = 0;
        $resource->isActive = (isset($request->isActive)) ? $request->isActive : 1;
        $resource->isDefault = (isset($request->isDefault)) ? $request->isDefault : 1;
        $resource->save();

        return $resource;
    }

    function getNames($leaveTypeId, $mss)
    {
        return [
            'leaveTypeName' => LeaveType::where('id', $leaveTypeId)->pluck('name')->first(),
            'delegateName' => Employee::where('id', Auth::user()->staff_id)->pluck('employeeName')->first(),
            'mssName' => $mss,

        ];
    }

    function returnDataCollection($resource, $names, $request)
    {
        return [
            'data' => [
                'id' => $resource->id,
                'leaveTypeName' => $names['leaveTypeName'],
                'employeeId' => Auth::user()->staff_id,
                'date_From' => date('d-m-Y', strtotime($request->date_From)),
                'date_To' => date('d-m-Y', strtotime($request->date_To)),
                'time_From' => $request->time_From,
                'time_To' => $request->time_To,
                'totalDurationDays' => $request->totalDurationDays,
                'delegateName' => $names['delegateName'],
                'mssName' => $names['mssName'],
                'reason' => $request->reason,
                'status' => 'Pending',
                'statusComment' => $resource->statusComment,
                'requestDate' => date('d-m-Y', strtotime($resource->created_at)),
                'isActive' => $request->isActive,
                'isDefault' => $request->isDefault,
                'updated_at' => $request->updated_at
            ]
        ];
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id)
    {
        $resource = LeaveRequest::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_From' => 'required',
            'date_To' => 'required',
            'reason' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->date_From = $request->date_From;
        $resource->date_To = $request->date_To;
        $resource->reason = $request->reason;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }

    public function getEachLeaveRequestLevel($leaveRequest)
    {
        $levels = [];
        $leaveApprovalRequestsList = LeaveApprovalRequests::where('leaveRequestId', $leaveRequest->id)->get();
        if (count($leaveApprovalRequestsList) > 0) {
            foreach ($leaveApprovalRequestsList as $request) {
                $mssUser = BasicInfo::where('staff_id', $request->userLevelId)->first();
                if (isset($mssUser)) {
                    $levels [] = [
                        'levelPosition' => $request->next_level,
                        'mssName' => $mssUser->familyName,
                        'mssImage' => $mssUser->employeeImageUrl,
                        'status' => $request->status,
                        'errorMessage' => ''
                    ];
                }
            }
        }
        return $levels;
    }

    function updateStatus($leaveRequest, $status = 1)
    {
        $leaveRequest->requestStatus = $status;
        $leaveRequest->updated_at = date("Y-m-d H:i:s");
        $leaveRequest->save();
    }

    public function leaveReject($request)
    {
        $leaveApprovalRequestPrev = LeaveApprovalRequests::where('leaveRequestId', $request->leaveRequestId)
            ->where('next_level', $request->nextLevel)->first();
        $leaveRequest = LeaveRequest::where('id', $request->leaveRequestId)->first();
//        $updateReject = LeaveApprovalRequests::where('leaveRequestId', $request->leaveRequestId)->orderBy('id', 'desc')->first();
//        $updateReject->status = 'Rejected';
//        $updateReject->updated_at = date("Y-m-d H:i:s");
//        $updateReject->save();

        $this->updateStatus($leaveRequest, 2);
        $storeData = [
            'status' => 'Rejected',
            'nextLevel' => null
        ];
        app('App\Models\Leave\LeaveApprovalRequests')
            ->updateStatus($leaveApprovalRequestPrev, $storeData);

        return 'Rejected';
    }

    function mssAcceptanceStore($storeData)
    {
        $insert = new LeaveApprovalRequests();
        $insert->leaveRequestId = $storeData->leaveRequestId;
        $insert->userLevelId = $storeData->userLevelId;
        $insert->status = $storeData->status;
        $insert->next_level = $storeData->nextLevel;
        $insert->save();
    }

    function mssLastLevelAccept($leaveApprovalRequestPrev, $leaveRequest)
    {
        $storeData = [
            'status' => 'Accepted',
            'nextLevel' => null
        ];
        app('App\Models\Leave\LeaveApprovalRequests')->updateStatus($leaveApprovalRequestPrev, $storeData);
        $this->updateStatus($leaveRequest);
    }

    function secondTimeBridgeLeaveAccept($request, $approvalFlowTypeId)
    {
        $leaveRequest = LeaveRequest::where('id', $request->leaveRequestId)->first();
        $leave_approval_request_prev = LeaveApprovalRequests::where('leaveRequestId', $request->leaveRequestId)
            ->where('next_level', $request->nextLevel)->first();

        if ($leave_approval_request_prev->next_level < 8) {
            $approvalFlowNextLevel = ApprovalFlowLevel::select('level')->where('approval_flow_type_id', $approvalFlowTypeId)
                ->skip($leave_approval_request_prev->next_level)->first();
            // dd($approvalFlowTypeId);
            $next_level_mss_id = 0;      //  return $approvalFlowNextLevel;
            // if there is a next level
            if (isset($approvalFlowNextLevel->level)) {
                $next_level_mss_id = $approvalFlowNextLevel->level;

                $insert = new LeaveApprovalRequests();
                $insert->leaveRequestId = $request->leaveRequestId;
                $insert->userLevelId = $next_level_mss_id;
                $insert->status = 'Pending';
                $insert->next_level = $leave_approval_request_prev->next_level + 1;
                $insert->save();

            } //  if there is no next level:: next level is null
            else {
                $insert = new LeaveApprovalRequests();
                $insert->leaveRequestId = $request->leaveRequestId;
                $insert->userLevelId = $request->mssId;
                $insert->status = 'Accepted';
                $insert->next_level = 0;
                $insert->save();

                $leaveRequest->requestStatus = 1;
                app('App\Models\Leave\AllocatedLeaveTypes')->updateLeaveBalance($leaveRequest);
                app('App\Models\Leave\BridgeLeaveCount')->increaseBridgeLeaveCount($leaveRequest->staff_id);
            }
        } // if this is the last level: that means level 8th
        else {
            $insertAccept = new LeaveApprovalRequests();
            $insertAccept->leaveRequestId = $request->leaveRequestId;
            $insertAccept->userLevelId = $request->mssId;
            $insertAccept->status = 'Accepted';
            $insertAccept->save();

            $leaveRequest->requestStatus = 1;

            app('App\Models\Leave\AllocatedLeaveTypes')->updateLeaveBalance($leaveRequest);
        }

        $leaveRequest->updated_at = date("Y-m-d H:i:s");
        $leaveRequest->save();

        $leave_approval_request_prev->status = 'Accepted';
        $leave_approval_request_prev->save();

        return $leave_approval_request_prev->status;
    }

    function getNextLevelMssId($approvalFlowNextLevel, $approvalFlowTypeId, $leaveRequest){
        if($approvalFlowTypeId == 1) {
            $nextLevelMssId = ($approvalFlowNextLevel == 'second_line_manager') ? EmployeeInfo::where('staff_id', $leaveRequest->staff_id)->pluck('lineManager_2nd')->first() :
                (($approvalFlowNextLevel == 'hrbp') ? EmployeeInfo::where('staff_id', $leaveRequest->staff_id)->pluck('hrbp')->first() :
                    $approvalFlowNextLevel ) ;
            // ekhane 1ta [roblem hote pare int and varchar e
        }
        else{
            $nextLevelMssId = $approvalFlowNextLevel;
        }

        return $nextLevelMssId;
    }
    // 72 29 27 24 18
    function leaveAccept($request, $approvalFlowTypeId)
    {
        $leaveRequest = LeaveRequest::where('id', $request->leaveRequestId)->first();
        $leaveApprovalRequestPrev = LeaveApprovalRequests::where('leaveRequestId', $request->leaveRequestId)
            ->where('next_level', $request->nextLevel)->first();
        if ($leaveApprovalRequestPrev->next_level < 8) { // 8 is the last level if present
            $approvalFlowNextLevel = ApprovalFlowLevel::where('approval_flow_type_id', $approvalFlowTypeId)
                ->skip($leaveApprovalRequestPrev->next_level)->pluck('level')->first();
                  //  return $approvalFlowNextLevel;
            // if there is a next level
            if (isset($approvalFlowNextLevel)) {
                $nextLevelMssId = $this->getNextLevelMssId($approvalFlowNextLevel, $approvalFlowTypeId, $leaveRequest);

                $storeData = [
                    'leaveRequestId' => $request->leaveRequestId,
                    'userLevelId' => $nextLevelMssId,
                    'status' => 'Pending',
                    'nextLevel' => $leaveApprovalRequestPrev->next_level + 1
                ];
                $this->mssAcceptanceStore($storeData);

            } //  if there is no next level:: next level is null
            else {
                $this->mssLastLevelAccept($leaveApprovalRequestPrev, $leaveRequest);
            }
        } // if this is the last level: that means level 8th
        else {
            $this->mssLastLevelAccept($leaveApprovalRequestPrev, $leaveRequest);
        }
        app('App\Models\Leave\AllocatedLeaveTypes')->updateLeaveBalance($leaveRequest);

        return 'Accepted';
    }

    function leaveAcceptance($request)
    {
        //   $leaveRequestId, $mssId
        $leaveRequest = LeaveRequest::where('id', $request->leaveRequestId)->first();
        $typeName = ($leaveRequest->isBridge) ? 'Bridge' : 'Leave';
        $approvalFlowType = ApprovalFlowType::where('name', 'like', "%{$typeName}%")->pluck('id')->first();

        if ($request->status == 'accept') {
            //$this->secondTimeBridgeLeaveAccept($request, $approvalFlowType) :
            $this->leaveAccept($request, $approvalFlowType);
        } else if ($request->status == 'reject') {
            $status = $this->leaveReject($request);
        }

        return $status;
    }

//    function returnDataCollection($resource, $names, leave type, mssname ], $request)
    function getLeaveRequestDataCollection($leaveRequest, $names, $employeeId, $status)
    {
        return [
            'id' => $leaveRequest->id,
            'leaveTypeName' => $names['leaveTypeName'],
            'employeeId' => $employeeId,
            'date_From' => date('d-m-Y', strtotime($leaveRequest->date_From)),
            'date_To' => date('d-m-Y', strtotime($leaveRequest->date_To)),
            'time_From' => $leaveRequest->time_From,
            'time_To' => $leaveRequest->time_To,
            'totalDurationDays' => $leaveRequest->totalDurationDays,
            'delegateName' => $names['delegateName'],
            'isBridge' => $leaveRequest->isBridge,
            'mssName' => $names['mssName'],
            'reason' => $leaveRequest->reason,
            'status' => $status,
            'statusComment' => $leaveRequest->statusComment,
            'requestDate' => date('d-m-Y', strtotime($leaveRequest->created_at)),
            'levels' => $this->getEachLeaveRequestLevel($leaveRequest),
            'isActive' => $leaveRequest->isActive,
            'isDefault' => $leaveRequest->isDefault,
            'updated_at' => $leaveRequest->updated_at,
            'errorMessage' => ''
        ];
    }

    function getDifferentNames($request, $employeeId)
    {
        $mssLevelUserId = LeaveApprovalRequests::select('userLevelId')->where('leaveRequestId', $request->id)->first();
        $leaveTypeName = LeaveType::select('name')->where('id', $request->leave_type_id)->first();
        $delegateName = Employee::select('employeeName')->where('id', $employeeId)->first();
        $mssName = Employee::select('employeeName')->where('id', $mssLevelUserId->userLevelId)->first();
        if(isset($leaveTypeName) && isset($delegateName) && isset($mssName) )
            return [
                'leaveTypeName' => $leaveTypeName->name,
                'delegateName' => $delegateName->employeeName,
                'mssName' => $mssName->employeeName
            ];
        else return [];
    }

    public function getLeaveRequestList($employeeId)
    {
        $data = [];
        $leaveRequests = LeaveRequest::where('staff_id', $employeeId)->orderBy('id', 'desc')->get();
        if (count($leaveRequests) > 0) {
            foreach ($leaveRequests as $request) {
                $status = ($request->requestStatus == 0) ? 'Pending' : (($request->requestStatus == 1) ? 'Accepted' : (($request->requestStatus == 2) ? 'Rejected' : ''));
                $names = $this->getDifferentNames($request, $employeeId);

                if(!empty($names))
                    $data[] = $this->getLeaveRequestDataCollection($request, $names, $employeeId, $status);
                else {
                    return [   'data' => []    ];
                }
            }
            return ['data' => $data];
        } else {
            return ['data' => $data];
        }
    }
}
