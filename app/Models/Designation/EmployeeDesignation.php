<?php

namespace App\Models\Designation;

use App\Events\GenericRedisEvent;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class EmployeeDesignation extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new EmployeeDesignation();

        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;
        $resource->created_by = $request->created_by;
        $resource->updated_by = $request->updated_by;
        $resource->deleted_by = $request->deleted_by;
        $resource->created_by = 
        $resource->updated_by = 
        $resource->deleted_by = 
            

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }

    function updateResource($request, $id) {
        $resource = EmployeeDesignation::find($id);

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
        event(new GenericRedisEvent($resource));

        return $resource;
    }
}
