<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base;
use App\Models\Employee\EmployeeEducationInfo;
use App\Models\Employee\BasicInfo;
use App\Models\Employee\EmployeeContactInfo;
use App\Models\Employee\EmployeeFamilyMemberInfo;

/**
 * @method static find($staff_id)
 */
class Employee extends Base
{
    protected $table = "employees";

    public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }

    public function basicInfo()
    {
        return $this->hasOne('App\Models\Employee\BasicInfo');
    }

    function user(){
        return $this->belongsTo('App\User','id','staff_id');
    }
    function contact(){
        return $this->belongsTo('App\Models\Employee\EmployeeContactInfo', 'id','staff_id');
    }


    function storeResource($request)
    {
        // $validator = Validator::make($request->all(), [
        //     // 'name' =>  'required',
        //     'isActive' => 'required',
        //     'isDefault' => 'required'
        // ]);

        // if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        // dd($request);
        $resource = new Employee();
        $resource->employeeName = $request->familyName;

        $resource->save();

        return $resource;
    }

    public function employeeBasicInfo($id)
    {
        return BasicInfo::where('staff_id', $id)->first();
    }

    public function employeeEducationInfo($id)
    {
        return EmployeeEducationInfo::where('staff_id', $id)->first();
    }

    public function employeeContactInfo($id)
    {
        return EmployeeContactInfo::where('staff_id', $id)->first();
    }

    public function employeeFamilylInfo($id)
    {
        return EmployeeFamilyMemberInfo::where('staff_id', $id)->get();
    }

    function getEmployeeName($employees)
    {
        $data = [];
        foreach ($employees as $employee) {
            $resource = Employee::where('id', $employee->staff_id)->first();
            $data[] = [
                'id' => $resource->id,
                'name' => $resource->employeeName
            ];
        }

        return ['data' => $data];
    }
}
