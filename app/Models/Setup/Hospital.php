<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Hospital extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    /**
     * @param $request
     * @return \App\Http\Resources\Setup\Hospital
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $hospital = new Hospital();

        $hospital->name = $request->name;
        $hospital->isActive = $request->isActive;
        $hospital->isDefault = $request->isDefault;
        $hospital->created_by = $request->created_by;
        $hospital->updated_by = $request->updated_by;
        $hospital->deleted_by = $request->deleted_by;
        $hospital->save();

        return new \App\Http\Resources\Setup\Hospital($hospital);
    }

    function updateResource($request, $id) {
        $resource = Hospital::find($id);

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
        $resource->created_by = $request->created_by;
        $resource->updated_by = $request->updated_by;
        $resource->deleted_by = $request->deleted_by;

        $resource->save();
        return $resource;
    }
}
