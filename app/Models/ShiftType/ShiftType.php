<?php

namespace App\Models\ShiftType;

use App\Models\Employee\EmployeeInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class ShiftType extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    /**
     * @param $request
     * @return Shift
     */
    function storeResource($request)
    {

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'graceTime' =>  'required',
            'daysOfWeek' => 'required',
            'startTime' =>  'required',
            'endTime' => 'required',
            'lunchStartTime' => 'required',
            'lunchEndTime' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        $resource = new ShiftType();
        $resource->name = $request->name;
        $resource->graceTime = Helper::formatTime($request->graceTime);

        $resource->daysOfWeek = is_array($request->daysOfWeek)? implode(",",$request->daysOfWeek) : '';

        $resource->weekEnds = Helper::weekends($request->daysOfWeek);


        $resource->startTime = Helper::formatTime($request->startTime);
        $resource->endTime = Helper::formatTime($request->endTime);
        $resource->lunchStartTime =  Helper::formatTime($request->lunchStartTime);
        $resource->lunchEndTime = Helper::formatTime($request->lunchEndTime);

        if ($request->has('startDate')) {
            $resource->startDate = Helper::formatdate($request->startDate);
        }
        if ($request->has('endDate')) {
            $resource->endDate = Helper::formatdate($request->endDate);
        }

        $resource->save();

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id) {

        $resource = ShiftType::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'graceTime' =>  'required',
            'daysOfWeek' => 'required',
            'startTime' =>  'required',
            'endTime' => 'required',
            'lunchStartTime' => 'required',
            'lunchEndTime' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->graceTime = Helper::formatTime($request->graceTime);

        $resource->daysOfWeek = is_array($request->daysOfWeek)?json_encode(implode(",",$request->daysOfWeek)):'';

        $resource->weekEnds = Helper::weekends($request->daysOfWeek);


        $resource->startTime = Helper::formatTime($request->startTime);
        $resource->endTime = Helper::formatTime($request->endTime);
        $resource->lunchStartTime =  Helper::formatTime($request->lunchStartTime);
        $resource->lunchEndTime = Helper::formatTime($request->lunchEndTime);

        if ($request->has('startDate')) {
            $resource->startDate = Helper::formatdate($request->startDate);
        }
        if ($request->has('endDate')) {
            $resource->endDate = Helper::formatdate($request->endDate);
        }
        $resource->save();

        return $resource;
    }
    public function EmployeeInfo()
    {
        return $this->belongsTo('App\Models\Employee\EmployeeInfo','shiftType_id');
    }

    function isWeekend($date, $prevOrNext)
    {
        $prevOrNextDay = ($prevOrNext == 'previous') ? Carbon::parse($date)->subDays(1) : Carbon::parse($date)->addDays(1);
        $employeesShiftTypeId = EmployeeInfo::where('staff_id', Auth::user()->staff_id)->pluck('shiftType_id')->first();
        $getWeekEndsForThisEmployee = ShiftType::where('id', $employeesShiftTypeId)->pluck('weekEnds')->first();
        $weekEndArray = explode(',', $getWeekEndsForThisEmployee);
        $isWeekend = false;

        foreach ($weekEndArray as $weekend) {
            if (string(strtolower($weekend)) == string(strtolower($prevOrNextDay->dayName))) {
                $isWeekend = true;
                break;
            }
        }
        return $isWeekend;
    }

}


