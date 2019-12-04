<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
class EmployeeLocation extends Base
{
    public function __construct( )
    {
        parent::__construct($this);
    }  

/**
     * @param $request
     * @return EmployeeLocation
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404); 
        
        $resource = new EmployeeLocation();

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
        $resource = EmployeeLocation::find($id);

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
}
