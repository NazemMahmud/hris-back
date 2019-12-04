<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;

class EmployeeChilden extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {
        $resource = new EmployeeChilden();
        $resource->name = $request->name;

        if(($request->gender_id)&& !empty($request->gender_id)){
            $resource->gender_id = $request->gender_id;
        }
        if(($request->dob)&& !empty($request->dob)){
            $resource->dob = $request->dob;
        }
        if(($request->place_of_birth)&& !empty($request->place_of_birth)){
            $resource->place_of_birth = $request->place_of_birth;
        }
        if(($request->isActive)&& !empty($request->isActive)){
            $resource->isActive = $request->isActive;
        }
        if(($request->isDefault)&& !empty($request->isDefault)){
            $resource->isDefault = $request->isDefault;
        }
        $resource->save();

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id) {
        $resource = EmployeeChilden::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);
        $resource = new EmployeeChilden();
        $resource->name = $request->name;
        if(($request->isActive)&& !empty($request->isActive)){
            $resource->isActive = $request->isActive;
        }
        if(($request->isDefault)&& !empty($request->isDefault)){
            $resource->isDefault = $request->isDefault;
        }
        $resource->save();

        return $resource;
    }
}
