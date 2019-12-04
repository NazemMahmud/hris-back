<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class EmployeeEducationInfo extends Base
{
    public function __construct( )
    {
        parent::__construct($this);
    }  

/**
     * @param $request
     * @return EmployeeEducationInfo
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'staff_id' =>  'required',
            'education_level' =>  'required',
            'institution_name' =>  'required',
            'country' =>  'required',
            'graduation_year' =>  'required',
            'result' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404); 
        
        $resource = new EmployeeEducationInfo();

        $resource->staff_id = $request->staff_id;
        $resource->education_level = $request->education_level;
        $resource->institution_name = $request->institution_name;
        $resource->country = $request->country;
        $resource->graduation_year =  Helper::formatdate($request->graduation_year);
        $resource->result = $request->result;
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
        $resource = EmployeeEducationInfo::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'staff_id' =>  'required',
            'education_level' =>  'required',
            'institution_name' =>  'required',
            'country' =>  'required',
            'graduation_year' =>  'required',
            'result' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->staff_id = $request->staff_id;
        $resource->education_level = $request->education_level;
        $resource->institution_name = $request->institution_name;
        $resource->country = $request->country;
        $resource->graduation_year =  Helper::formatdate($request->graduation_year);
        $resource->result = $request->result;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
}
