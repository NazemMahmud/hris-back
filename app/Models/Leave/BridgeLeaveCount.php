<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class BridgeLeaveCount extends Model
{
    protected $table = "employee_bridge_leave_count";

    function store($data)
    {
        $resource = new BridgeLeaveCount();
        $resource->staff_id = $data['staff_id'];
        $resource->count = $data['count'];
        $resource->save();
    }

    function increaseBridgeLeaveCount($staffId){
        $resource = BridgeLeaveCount::where('staff_id', $staffId)->first();
        if($resource->count <=1) {
            $resource->count = $resource->count + 1;
            $resource->save();
        }
    }

    function getBridgeLeaveInfo($bridgeLeaveCount){
        $resource = BridgeLeaveCount::where('staff_id', $bridgeLeaveCount['staff_id'])->first();

        $message = ($resource->count == 0) ? 'You are about to take a bridge leave' :
            (($resource->count == 1) ? 'You are about to take a bridge leave. But it will go through another flow' : '');
        return [
            'message' => $message,
            'counter' => $resource->count,
            'status' => ($resource->count == 0) ? 0 : (($resource->count == 1) ? 1 : 2)
        ];
    }
}
