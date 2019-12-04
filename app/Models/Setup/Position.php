<?php

namespace App\Models\Setup;

use App\Models\Base;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

/**
 * @method static find($position_id)
 */
class Position extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }


    /**
     * @param $request
     * @return Position
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Position();

        $resource->name = $request->name;
        $resource->code = Helper::UniqueString();
        if ($request->has('isActive')){
            $resource->isActive = $request->isActive;
        }
        if ($request->has('isDefault')){
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
        $resource = Position::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        if ($request->has('isActive')){
            $resource->isActive = $request->isActive;
        }
        if ($request->has('isDefault')){
            $resource->isDefault = $request->isDefault;
        }

        $resource->save();

        return $resource;
    }
}
