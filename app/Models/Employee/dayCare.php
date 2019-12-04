<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\EmployeeChildrenInfo;
use App\Models\Setup\Gender;
use App\Models\Setup\Country;
class dayCare extends Base
{
    protected $table = "day_cares";

    public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }

    function getAllData($staff_id){
        return dayCare::where('created_by',$staff_id)->where('deleted_at',null)->get();
    }

    function getAllStoredData($request){
        if (!$request->division_id && !$request->department_id){
            return dayCare::latest()->paginate(50);
        }

        $DayCareInfo = new dayCare();
        $DayCareInfo = $DayCareInfo->select('day_cares.*');
        $DayCareInfo = $DayCareInfo->Join('employee_info', 'employee_info.staff_id', '=', 'day_cares.staff_id');

        if (!empty($request->division_id) && $request->division_id!=null && $request->division_id!='null' ){
            $DayCareInfo = $DayCareInfo->where(['employee_info.org_division_id' => $request->division_id]);

        }
        if (!empty($request->department_id) && $request->department_id!=null && $request->department_id!='null' ){
            $DayCareInfo = $DayCareInfo->where(['employee_info.org_department_id' => $request->department_id]);
        }
        return $DayCareInfo = $DayCareInfo->orderBy('id', 'DESC')->paginate(50);
    }

    function storeResource($request) {

         $validator = Validator::make($request->all(), [
             'children_id' => 'required',
             'staff_id' => 'required',
             'justification' => 'required'
         ]);

         if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

         $childrenNumber =  dayCare::where('staff_id',$request->staff_id)->where('status',0)->count();

        if ($childrenNumber>2) return response()->json(['errors' => 'You can apply for only two children']);

        $resource = new dayCare();


        $resource->children_id = $request->children_id;
        $resource->justification = $request->justification;
        $resource->created_by = $request->staff_id;
        $resource->staff_id = $request->staff_id;

        if($request->has('guardian_name')){
            $resource->guardian_name = $request->guardian_name;
        }
        if($request->has('guardian_contract_number')){
            $resource->guardian_contract_number = $request->guardian_contract_number;
        }
        if($request->has('declaration')){
            $resource->declaration = $request->declaration;
        }
        $resource->status = 0;

        $resource->save();

        return $resource;
    }

    function updateResource($request, $id)
    {
        $resource = dayCare::where('id', '=', $id)->first();
        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'children_id' => 'required',
            'staff_id' => 'required',
            'justification' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->children_id = $request->children_id;
        $resource->justification = $request->justification;
        $resource->created_by = $request->staff_id;

        if ($request->has('guardian_name')) {
            $resource->guardian_name = $request->guardian_name;
        }
        if ($request->has('guardian_contract_number')) {
            $resource->guardian_contract_number = $request->guardian_contract_number;
        }
        if ($request->has('declaration')) {
            $resource->declaration = $request->declaration;
        }
        if ($request->has('status')) {
            $resource->status = $request->status;
        }
        $resource->save();

        return $resource;

    }
    public function checkIfDayCareHasSit(){
         return dayCare::where('status',1)->count();
    }

}
