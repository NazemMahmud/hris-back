<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
class WorkingDay extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'type' =>  'required',
        ]);
        if($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        $resource = new WorkingDay();
        $resource->type = $request->type;
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
        $resource = WorkingDay::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);
        $validator = Validator::make($request->all(), [
            'type' =>  'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        $resource = new WorkingDay();
        $resource->type = $request->type;
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
