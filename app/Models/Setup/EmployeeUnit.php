<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Models\Setup\EmployeeDivision;
use App\Models\Setup\EmployeeDepartment;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\EmployeeInfo;
use App\Models\Setup\Position;
use App\User;
class EmployeeUnit extends Base
{
    public $employeeDivision;
    public $employeeDepartment;

    public function __construct()
    {
        parent::__construct($this);
        $this->employeeDivision = new EmployeeDivision;
        $this->employeeDepartment = new EmployeeDepartment;


    }

/**
     * @param $request
     * @return EmployeeUnit
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'division_id' => 'required',
            'department_id' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);
        // return $request;
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);
        $resource = new EmployeeUnit();

        $resource->name = $request->name;
        $resource->division_id = $request->division_id;
        $resource->department_id = $request->department_id;
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
        $resource = EmployeeUnit::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'division_id' => 'required',
            'department_id' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->division_id = $request->division_id;
        $resource->department_id = $request->department_id;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
    public function getEmployeeunit($employeeId){
        $user = User::where('id',$employeeId)->select('staff_id')->first();
        if (!empty($user)){
            $org_unit = EmployeeInfo::where('staff_id',$user->staff_id)->select('org_unit_id')->first();
            if (!empty($org_unit)){
                return Position::where('unit_id',$org_unit->org_unit_id)->get();
            }
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }
}
