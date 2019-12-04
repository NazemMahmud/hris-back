<?php

namespace App\Models\ApprovalFlow;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Models\ApprovalFlow\ApprovalFlowType;

class ApprovalFlowLevel extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    public function getAllFlowLevels()
    {
        $allTypes = ApprovalFlowType::all();
        $data = [];
        $status = 0;
        foreach ($allTypes as $types) {
            $allLevels = ApprovalFlowLevel::where('approval_flow_type_id', $types->id)->get();
            $levels = [];
            foreach ($allLevels as $request) {
                $levelName = '';
                if (isset($request->level)) {
                    // if (is_numeric($request->level))

                    $employee = Employee::select('employeeName')->where('id', $request->level)->first();

                    $levelName = (isset($employee)) ? $employee->employeeName : $request->level;
                    if ($levelName == 'first_line_manager') $levelName = 'First Line Manager';
                    if ($levelName == 'second_line_manager') $levelName = 'Second Line Manager';
                    if ($levelName == 'hrbp') $levelName = 'HRBP';
                }

                $levels[] = [
                    'levelName' => $levelName,
                ];
            }
            if ($allLevels->isEmpty()) {
            } else {
                $data [] = [
                    'id' => $types->id,
                    'name' => $types->name,
                    'levelOne' => $levels[0]['levelName'],
                    'levelTwo' => $levels[1]['levelName'],
                    'levelThree' => $levels[2]['levelName'],
                    'levelFour' => $levels[3]['levelName'],
                    'levelFive' => $levels[4]['levelName'],
                    'levelSix' => $levels[5]['levelName'],
                    'levelSeven' => $levels[6]['levelName'],
                    'levelEight' => $levels[7]['levelName'],
                    'updated_at' => $types->updated_at
                ];
            }
        }
        $leaveRequestData = [ 'data' => $data  ];

        return $leaveRequestData;
    }

//    function store($workFlowType, $level, $isActive, $isDefault)
    function store($level, $flowTypeid)
    {
        $resource = new ApprovalFlowLevel();
        $resource->approval_flow_type_id = $flowTypeid;
        $resource->level = $level;
        $resource->save();
    }

//    function storeResource($request) {
    function storeResource($request, $flowTypeid)
    {
        /*   $validator = Validator::make($request->all(),
           [
               'workflowType' => 'required',
               'isDefault' => 'required',
               'isActive' => 'required'
           ]);

        //  if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        {"workflowType":{"id":1,"name":"Leave","isDefault":1,"isActive":1},
        "level_1st":{"name":"First Line Manager","value":"first_line_manager"},
        "level_2nd":{"name":"Second Line Manager","value":"second_line_manager"},
        "level_3rd":{"name":"HRBP","value":"hrbp"},
        "level_4th":{"id":6,"name":"Talha","created_at":"2019-08-29T04:58:17.000000Z","updated_at":"2019-08-29T04:58:17.000000Z"},
        "level_5th":"",
        "level_6th":"",
        "level_7th":"",
        "level_8th":"",
        "isActive":true,
        "isDefault":true}
        */
        $this->store($request->levelOne, $flowTypeid); $this->store($request->levelTwo, $flowTypeid);
        $this->store($request->levelThree, $flowTypeid); $this->store($request->levelFour, $flowTypeid);
        $this->store($request->levelFive, $flowTypeid); $this->store($request->levelSix, $flowTypeid);
        $this->store($request->levelSeven, $flowTypeid); $this->store($request->levelEight, $flowTypeid);

        $latestResource = ApprovalFlowLevel::where('approval_flow_type_id', $flowTypeid)->get();
        $data = [];
        $levels = [];

        foreach ($latestResource as $resource) {
            $levelName = '';
            if (isset($resource->level)) {
                if (is_numeric($resource->level))
                    $employee = Employee::select('employeeName')->where('id', $resource->level)->first();

                $levelName = (isset($employee)) ? $employee->employeeName : $resource->level;
                if ($levelName == 'first_line_manager') $levelName = 'First Line Manager';
                if ($levelName == 'second_line_manager') $levelName = 'Second Line Manager';
                if ($levelName == 'hrbp') $levelName = 'HRBP';
            }

            $levels[] = [
                'id' => $resource->id,
                'levelName' => $levelName,
                'isActive' => $resource->isActive,
                'isDefault' => $resource->isDefault,
                'updated_at' => $resource->updated_at
            ];
        }
        // $flowType = ApprovalFlowType::select('name')->where('id', $flowTypeid)->first();
        /*$data  = [
            'id' => $flowTypeid,
            'name' => $flowType->name,
            'levels' => $levels,
        ]; */

        return $levels;
    }

    function updateResource($request, $id)
    {
        $resource = ApprovalFlowLevel::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(),
            [
                'flowId' => 'required',
                'level' => 'required',
                'isDefault' => 'required',
                'isActive' => 'required'
            ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->flowId = $request->flowId;
        $resource->level = $request->level;
        $resource->isDefault = $request->isDefault;
        $resource->isActive = $request->isActive;

        $resource->save();
        return $resource;
    }

    public static function getCurrentLevel($levelId) {
        $level = ApprovalFlowLevel::where('id', '=', $levelId)->orderBy('id', 'DESC')->first();
        return $level;
    }

    public static function getApprovalLevels($level_type) {
        $flowType = ApprovalFlowType::where('name', 'like', "%{$level_type}%")->first();
        $flowLevel = ApprovalFlowLevel::select('id', 'level')->where('approval_flow_type_id',  $flowType->id)
                    ->orderBy('id', 'ASC')->get();
        return $flowLevel;
    }
}
