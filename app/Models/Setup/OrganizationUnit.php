<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class OrganizationUnit extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }


    /**
     * @param $request
     * @return OrganizationUnit
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new OrganizationUnit();

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
        $resource = OrganizationUnit::find($id);

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