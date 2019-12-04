<?php

namespace App\Http\Controllers\Leave;

use App\Helpers\FileuploadHelpers;
use App\Http\Resources\Leave\EmployeeLeaveRequestsListCollection;
use App\Http\Resources\Leave\EmployeeLeaveRequestsList as EmployeeLeaveRequestsListResource;

use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\ApprovalFlow\ApprovalFlowType;
use App\Models\Employee\BasicInfo;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeInfo;
use App\Models\Leave\AllocatedLeaveTypes;
use App\Models\Leave\LeaveApprovalRequests;
use App\Models\Setup\LeaveType;
use App\Models\Holiday\Holiday;
use App\Models\ShiftType\ShiftType;
use App\Models\Leave\BridgeLeaveCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leave\LeaveRequestCollection;
use App\Http\Resources\Leave\LeaveRequest as LeaveRequestResource;
use App\Models\Leave\LeaveRequest;
use Illuminate\Http\JsonResponse;
Use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveRequestController extends Controller
{

    /**
     * @var LeaveRequest
     */
    private $leaveRequest;
    private $holiday;
    private $shiftType;
    private $bridgeLeaveCount;

    public function __construct(LeaveRequest $leaveRequest, Holiday $holiday, ShiftType $shiftType, BridgeLeaveCount $bridgeLeaveCount)
    {
        $this->leaveRequest = $leaveRequest;
        $this->holiday = $holiday;
        $this->shiftType = $shiftType;
        $this->bridgeLeaveCount = $bridgeLeaveCount;
    }

    /**
     * Display a listing of the resource.
     *
     * @return LeaveRequestCollection
     */
    public function index()
    {
        return new LeaveRequestCollection($this->leaveRequest->getAll());
    }

    /**
     * @param $employeeId
     * @return array
     */
    public function getLeaveRequestList($employeeId)
    {
        return $this->leaveRequest->getLeaveRequestList($employeeId);
    }

    /**
     * @param $mssId
     * @return array
     */
    public function getLeaveRequests($mssId)
    {

        $leaveapprovalLists = LeaveApprovalRequests::where('userLevelId', $mssId)
            ->orderBy('id', 'desc')->get();
//        return $leaveapprovalLists;
        $data = [];
        foreach ($leaveapprovalLists as $request) {
//            Request Date, leaveTypeName, Date-- from, to, Time -- from, to, Total duration, delegatee Name, Reasaon,
//Request Status, Status Comment
            $leaveRequest = LeaveRequest::where('id', $request->leaveRequestId)->first();
            $leaveTypeName = LeaveType::select('name')->where('id', $leaveRequest->leave_type_id)->first();
            $delegate = Employee::select('employeeName')->where('id', $leaveRequest->delegatee)->first();
            $delegateName = (isset($delegate->employeeName)) ? $delegate->employeeName : '';
            // who request for leave ?
            $employee = Employee::select('employeeName')->where('id', $leaveRequest->staff_id)->first();
            $employeeName = (isset($employee->employeeName)) ? $employee->employeeName : '';

            $data[] = [
                'id' => $request->id,
                'requestDate' => date('d-m-Y', strtotime($leaveRequest->created_at)),
                'leaveRequestId' => $request->leaveRequestId,
                'leaveTypeName' => $leaveTypeName->name,
                'date_From' => date('d-m-Y', strtotime($leaveRequest->date_From)),
                'date_To' => date('d-m-Y', strtotime($leaveRequest->date_To)),
                'time_From' => $leaveRequest->time_From,
                'time_To' => $leaveRequest->time_To,
                'totalDurationDays' => $leaveRequest->totalDurationDays,
                'delegateName' => $delegateName,
                'reason' => $leaveRequest->reason,
                'status' => $request->status,
                'statusComment' => $leaveRequest->statusComment,
                'nextLevel' => $request->next_level,
                'employeeId' => $leaveRequest->staff_id,
                'employeeName' => $employeeName,
                'isActive' => $request->isActive,
                'isDefault' => $request->isDefault,
                'updated_at' => $request->updated_at
            ];
        }
        $leaveRequestData = ['data' => $data];
        return $leaveRequestData;
    }

    public function leaveFinalLevelAcceptance()
    {

    }

// 72 lines
    public function leaveAcceptance(Request $request)
    {
        $status = $this->leaveRequest->leaveAcceptance($request);
        return array('status' => $status); // $leave_approval_request_prev->status
    }

    public function checkBlridgeLeave($dateFrom, $dateTo)
    {
        $isPreviousDayHoliday = false;
        $isNextDayHoliday = false;

        $dateFrom = Carbon::parse($dateFrom);
        $dateTo = Carbon::parse($dateTo);

        $dayDifference = $dateTo->diffInDays($dateFrom);

        if ($dayDifference > 2) {
            return false;
        }

        $PreviousdayOfDateFrom = Carbon::parse($dateFrom)->subDays(1);
        $NextdayOfDateTo = Carbon::parse($dateTo)->addDays(1);

        $checkPrviousDay = Holiday::Where('date', $PreviousdayOfDateFrom)->first();
        $checkNextDay = Holiday::Where('date', $NextdayOfDateTo)->first();

        if ($checkPrviousDay) {
            $isPreviousDayHoliday = true;
        }
        if ($checkNextDay) {
            $isNextDayHoliday = true;
        }

        $employeesShiftTypeId = EmployeeInfo::Where('staff_id', Auth::user()->staff_id)->pluck('shiftType_id')->first();
        $getWeekEndsForThisEmployee = ShiftType::where('id', $employeesShiftTypeId)->pluck('weekEnds')->first();
        $weekEndArray = explode(',', $getWeekEndsForThisEmployee);

        foreach ($weekEndArray as $weekend) {
            if (string(strtolower($weekend)) == string(strtolower($PreviousdayOfDateFrom->dayName))) {
                $isPreviousDayHoliday = true;

            }
            if (string(strtolower($weekend)) == string(strtolower($NextdayOfDateTo->dayName))) {
                $isNextDayHoliday = true;
            }
        }

        if ($isPreviousDayHoliday || $isNextDayHoliday) {
            return true;
        }

    }

    /**
     * @param Request $request
     * @return EmployeeLeaveRequestsListCollection|mixed
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_From' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        $resource = $this->leaveRequest->storeResource($request);
        //        fileUpload
        FileuploadHelpers::fileUpload($request);
        $mss = '';
        if (is_null($request->bridgeLeaveStatus) || (isset($request->bridgeLeaveStatus) && $request->bridgeLeaveStatus !== 1))
            $mss = app('App\Models\Leave\LeaveApprovalRequests')->storeLeaveApprovalRequest($resource->id, Auth::user()->staff_id);
        else if (isset($request->bridgeLeaveStatus) && $request->bridgeLeaveStatus == 1)
            $mss = app('App\Models\Leave\LeaveApprovalRequests')->storeBridgeLeaveApprovalRequest($resource->id);

        $names = $this->leaveRequest->getNames($request->leaveTypeId, $mss);

        return $this->leaveRequest->returnDataCollection($resource, $names, $request);
    }

    public function secondTimeBridgeLeave(Request $request)
    {
        /*
           *set a flag 'confirmBridgeLeave' to check wheather user agreed to have the bridge leave or not.
           *forst time flag should not be there and it will go through all the
           *bridge leave checkings, if so, it will return a message for bridge leave stuffs confirmation.
           *a req will come again here with the flag having users will.
           *and complete the operation.
       */

        if (!$request->confirmBridgeLeave) {
            //no flag
            if ($this->checkBlridgeLeave($request->date_From, $request->date_To)) {
                $BridgeLeaveCountStatus = $this->checkbridgeLeaveCount();
                if ($BridgeLeaveCountStatus == "already taken") {
                    $checkIfSevenDaysBeforeRequest = Carbon::parse($request->date_From)->subDays(7);
                    $checkTodaysDays = Carbon::today();
                    if ($checkIfSevenDaysBeforeRequest !== $checkTodaysDays) {
                        return "you have already taken a bridge leave. You have to request seven dayago for another one.";
                    }
                } else {
                    return "you are about to have a bridge leave";
                }
            }

            //storing result for non bridge leave apply.

            $result = $this->leaveRequest->storeResource($request);
            return $result;

        } else {

            //have flag
            //operating logic for bridge leave stuffs.

            if ($request->confirmBridgeLeave == 'true') {
                $result = $this->leaveRequest->storeResource($request, true);
                return $result;
            } else {
                return 'You have disagreed to have the bridge leave, Would you like to request for another leave ??';
            }
        }
    }

    public
    function increaseBridgeLeaveCount($bridgeLeaveCount)
    {

    }

    public
    function checkBridgeLeaveCount()
    {
        $bridgeLeaveCount = BridgeLeaveCount::where('staff_id', Auth::user()->staff_id)->first();
        if (isset($bridgeLeaveCount)) {
            $resource = $this->bridgeLeaveCount->getBridgeLeaveInfo($bridgeLeaveCount);
            return $resource;
        } else {
            $data = ['staff_id' => Auth::user()->staff_id, 'count' => 0];
            $this->bridgeLeaveCount->store($data);
            return [
                'message' => "You are about to take a bridge leave",
                'counter' => 0,
                'status' => 0
            ];
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public
    function checkBridgeLeave(Request $request)
    {
        $isPreviousDayHoliday = $this->holiday->isHoliday(date('Y-m-d', $request["startDate"] / 1000), 'previous');
        $isNextDayHoliday = $this->holiday->isHoliday(date('Y-m-d', $request["endDate"] / 1000), 'next');
        $isPreviousDayWeekend = $this->shiftType->isWeekend(date('Y-m-d', $request["startDate"] / 1000), 'previous');
        $isNextDayWeekend = $this->shiftType->isWeekend(date('Y-m-d', $request["endDate"] / 1000), 'next');
        $bridgeLeaveCountStatus = [
            'status' => 'null'
        ];
        if (($isPreviousDayHoliday || $isPreviousDayWeekend) && ($isNextDayHoliday || $isNextDayWeekend))
            $bridgeLeaveCountStatus = $this->checkBridgeLeaveCount();
        return [
            'data' => $bridgeLeaveCountStatus
        ];
    }

    /**
     * @param $id
     * @return LeaveRequestResource|JsonResponse
     */
    public
    function show($id)
    {
        $result = $this->leaveRequest->getResourceById($id);
//        return $result;
        return (is_object(json_decode($result))) === false ? $result : new LeaveRequestResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return LeaveRequestResource|JsonResponse
     */
    public
    function update(Request $request, $id)
    {
        $result = $this->leaveRequest->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ? $result : new LeaveRequestResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return LeaveRequestResource|JsonResponse
     */
    public
    function destroy($id)
    {
        $result = $this->leaveRequest->deleteResource($id);
        return (is_object(json_decode($result))) === false ? $result : new LeaveRequestResource($result);
    }
}
