<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Models\Setup\EmployeeDivision;

class EmployeeDepartment extends Base
{
    private $employeeDivision;

    public function __construct()
    {
        parent::__construct($this);
        $this->employeeDivision = new EmployeeDivision;
    }

    /**
     * @param $request
     * @return EmployeeDepartment
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'division_id' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);

        $division = $this->employeeDivision->getResourceById($request->division_id);
        if(empty($division)) return response()->json(['errors', 'Invalid division id'], 500);

        $resource = new EmployeeDepartment();

        $resource->name = $request->name;
        $resource->division_id = $request->division_id;
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
        $resource = EmployeeDepartment::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'division_id' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->division_id = $request->division_id;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
    public function departmentByDivision($department_id){

        $resource = EmployeeDepartment::where('division_id',$department_id)->get();
        if (count($resource)==0) return response()->json(['message' => 'Resource not found.'], 404);
        return $resource;
    }
}
