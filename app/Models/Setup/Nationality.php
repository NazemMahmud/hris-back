<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\Base;
use App\Http\Resources\Setup\Nationality as NationalityResource;

class Nationality extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    public function BasicInfo() {
        return $this->belongsTo('App\Models\Employee\BasicInfo');
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Nationality();

        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        $resource;
    }

    function updateResource($request, $id) {
        $resource = Nationality::find($id);

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
