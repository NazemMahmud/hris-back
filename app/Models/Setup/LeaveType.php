<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;

class LeaveType extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }


    /**
     * @param $request
     * @return LeaveType
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'maximumdays' =>  'required',
            'carryForwardDayAnnually' => 'required',
            'includedWithAnnualLeave' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new LeaveType();

        $resource->name = $request->name;
        $resource->maximumdays = $request->maximumdays;
        $resource->carryForwardDayAnnually = $request->carryForwardDayAnnually;
        $resource->includedWithAnnualLeave = $request->includedWithAnnualLeave;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id) {
        $resource = LeaveType::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'maximumdays' => 'required',
            'carryForwardDayAnnually' => 'required',
            'includedWithAnnualLeave' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->maximumdays = $request->maximumdays;
        $resource->carryForwardDayAnnually = $request->carryForwardDayAnnually;
        $resource->includedWithAnnualLeave = $request->includedWithAnnualLeave;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
}
