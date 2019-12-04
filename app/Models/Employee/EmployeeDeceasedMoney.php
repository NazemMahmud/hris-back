<?php

namespace App\Models\Employee;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeceasedMoney extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request){
        $resource = EmployeeDeceasedMoney();
        
        if(empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $resource->staff_id = $request->staff_id;
        $resource->money = $request->money;

        $resource->save();
        return $resource;
    }

    function updateResource($request, $id){
        $resource = EmployeeDeceasedMoney::find($id);

        if(empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $resource->staff_id = $request->staff_id;
        $resource->money = $request->money;

        $resource->save();
        return $resource;



    }
}
