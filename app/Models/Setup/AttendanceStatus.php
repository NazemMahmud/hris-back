<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;

class AttendanceStatus extends Base
{
    public function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'status' =>  'required',

        ]);
        // return $request;
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);
        $resource = new AttendanceStatus();

        $resource->status = $request->status;

        if ($request->has('created_by')){
            $resource->created_by = $request->created_by;
        }
        if ($request->has('updated_by')){
            $resource->deleted_by = $request->deleted_by;
        }
        if ($request->has('isActive')){
            $resource->isActive = $request->isActive;
        }
        if ($request->has('softDelete')){
            $resource->softDelete = $request->softDelete;
        }

        $resource->save();

        return $resource;
    }

    function updateResource($request, $id) {
        $resource = AttendanceStatus::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'status' =>  'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->status = $request->status;

        if ($request->has('created_by')){
            $resource->created_by = $request->created_by;
        }
        if ($request->has('updated_by')){
            $resource->deleted_by = $request->deleted_by;
        }
        if ($request->has('isActive')){
            $resource->isActive = $request->isActive;
        }
        if ($request->has('softDelete')){
            $resource->softDelete = $request->softDelete;
        }

        $resource->save();

        return $resource;
    }
}
