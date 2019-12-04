<?php

namespace App\Models\ApprovalFlow;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;

class ApprovalFlowType extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function getAll($resourcePerPage = 0, $orderBy = 'DESC') {
        $allTypes = app('App\Models\ApprovalFlow\ApprovalFlowLevel')->getAllFlowLevels();

        return $allTypes;
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new ApprovalFlowType();
        $resource->name = $request->name;
        $resource->save();
        $approvalFlowLevel = app('App\Models\ApprovalFlow\ApprovalFlowLevel')->storeResource($request, $resource->id);

        $data = [
            'id' => $resource->id,
            'name' => $resource->name,
            'levelOne' => $approvalFlowLevel[0]['levelName'],
            'levelTwo' => $approvalFlowLevel[1]['levelName'],
            'levelThree' => $approvalFlowLevel[2]['levelName'],
            'levelFour' => $approvalFlowLevel[3]['levelName'],
            'levelFive' => $approvalFlowLevel[4]['levelName'],
            'levelSix' => $approvalFlowLevel[5]['levelName'],
            'levelSeven' => $approvalFlowLevel[6]['levelName'],
            'levelEight' => $approvalFlowLevel[7]['levelName'],
            'updated_at' => $resource->updated_at
        ];

        return $data;
    }

    function updateResource($request, $id)
    {
        $resource = ApprovalFlowType::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'isDefault' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->isDefault = $request->isDefault;
        $resource->isActive = $request->isActive;

        $resource->save();
        return $resource;
    }
}
