<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Models\Setup\EmployeeLocation;

class EmployeeSublocation extends Base
{
    private $employeeLocation;
    public function __construct()
    {
        parent::__construct($this);
        $this->employeeLocation = new EmployeeLocation;

    }  

/**
     * @param $request
     * @return EmployeeSublocation
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'location_id' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404); 
        
        // $location = $this->employeeLocation->getResourceById($request->location_id);
        // if(empty($location)) return response()->json(['errors', 'Invalid division id'], 500);

        $resource = new EmployeeSublocation();

        $resource->name = $request->name;
        $resource->location_id = $request->location_id;
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
        $resource = EmployeeSublocation::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'location_id' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->location_id = $request->location_id;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
}
