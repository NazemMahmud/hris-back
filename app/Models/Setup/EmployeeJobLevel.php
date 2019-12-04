<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\EmployeeInfo;
use App\User;
class EmployeeJobLevel extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }
    /**
     * @param $request
     * @return EmployeeJobLevel
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new EmployeeJobLevel();

        $resource->name = $request->name;
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
        $resource = EmployeeJobLevel::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
    function getJobLevel($employeeId){
        $user = User::where('id',$employeeId)->select('staff_id')->first();
        if (!empty($user)){
            $jobLevel = EmployeeInfo::where('staff_id',$user->staff_id)->select('jobLevel_id')->first();
            if(!empty($jobLevel)){
                return EmployeeJobLevel::where('id','>',$jobLevel->jobLevel_id)->get();
            }
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }
}
