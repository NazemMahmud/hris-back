<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\Base;
use App\Helpers\Helper;
use App\Models\Setup\Gender;
use App\Models\Setup\Country;
class EmployeeChildrenInfo extends Base
{
    protected $table = "employee_children_infos";
    public function __construct()
    {
        parent::__construct($this);
    }

    public function gender(){
        return $this->belongsTo('App\Models\Setup\Gender','gender_id','id');
    }

    function storeResource($request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'staff_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);

        $resource = new EmployeeChildrenInfo();
        $resource->name = $request->name;
        $resource->staff_id = $request->staff_id;

        if($request->has('gender_id')){
            $resource->gender_id = $request->gender_id;
        }
        if($request->has('date_From')){
            $resource->date_From = $request->date_From;
        }
        if($request->has('place_of_birth')){
            $resource->place_of_birth = $request->place_of_birth;
        }
        if($request->has('dob')){
            $resource->dob = Helper::formatdate($request->dob);
        }
        if($request->has('created_by')){

            $resource->created_by = $request->staff_id;
        }
        if($request->has('updated_by')){
            $resource->updated_by = $request->staff_id;
        }
        if($request->has('description')){
            $resource->description = $request->description;
        }
        if($request->has('status')){
            $resource->status = $request->status;
        }
        $resource->save();

        return $resource;
    }

    public function EmployeeWiseChildren($staffId){

        $resource = EmployeeChildrenInfo::where('staff_id',$staffId)->get();
        if (count($resource)==0) return response()->json(['errors' => 'Resource not found'], 404);
        return $resource;
    }

    function updateResource($request, $id)
    {
        $resource = EmployeeChildrenInfo::where('id', '=', $id)->first();

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'staff_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);

        $resource->name = $request->name;
        $resource->staff_id = $request->staff_id;
        if($request->has('gender_id')){
            $resource->gender_id = $request->gender_id;
        }
        if($request->has('date_From')){
            $resource->date_From = $request->date_From;
        }
        if($request->has('place_of_birth')){
            $resource->place_of_birth = $request->place_of_birth;
        }
        if($request->has('dob')){
            $resource->dob = Helper::formatdate($request->dob);
        }
        if($request->has('created_by')){
            $resource->created_by = $request->staff_id;
        }
        if($request->has('updated_by')){
            $resource->updated_by = $request->staff_id;
        }
        if($request->has('description')){
            $resource->description = $request->description;
        }
        if($request->has('status')){
            $resource->status = $request->status;
        }
        $resource->save();

        return $resource;
    }
}
