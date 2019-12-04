<?php

namespace App\Http\Controllers\ApprovalFlow;

use App\Http\Resources\ApprovalFlow\ApprovalFlowLevelCollection;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovalFlow\ApprovelFlowLevelCollection;
use App\Http\Resources\ApprovalFlow\ApprovalFlowLevel as ApprovalFlowLevelResource;
use App\Models\ApprovalFlow\ApprovalFlowType;
use Illuminate\Http\JsonResponse;


class ApprovalFlowLevelController extends Controller
{
    /**
     * @var ApprovalFlowLevel
     */
    private $approvalFlowLevel;

    public function __construct(ApprovalFlowLevel $approvalFlowLevel)
    {
        $this->approvalFlowLevel = $approvalFlowLevel;
    }

    /**
     * @return ApprovalFlowLevelCollection
     */
    public function index()
    {
        return new ApprovalFlowLevelCollection($this->approvalFlowLevel->getAll());
    }

//    public function getAllFlowLevels()
//    {
//        $allTypes = ApprovalFlowType::all();
//        $data = [];
//        $status = 0;
//        foreach ($allTypes as $types) {
//            $allLevels = ApprovalFlowLevel::where('approval_flow_type_id', $types->id)->get();
//            $levels = [];
//            foreach ($allLevels as $request) {
//                $levelName = '';
//                if (isset($request->level)) {
//                    if (is_numeric($request->level))
//                        $employee = Employee::select('employeeName')->where('id', $request->level)->first();
//
//                    $levelName = (isset($employee)) ? $employee->employeeName : $request->level;
//                    if ($levelName == 'first_line_manager') $levelName = 'First Line Manager';
//                    if ($levelName == 'second_line_manager') $levelName = 'Second Line Manager';
//                    if ($levelName == 'hrbp') $levelName = 'HRBP';
//                }
//
//                $levels[] = array(
////                    'id' => $request->id,
//                    'levelName' => $levelName,
////                    'isActive' => $request->isActive,
////                    'isDefault' => $request->isDefault,
////                    'updated_at' => $request->updated_at
//                );
//            }
//            if ($allLevels->isEmpty()) {
//            } else {
//                $data [] = [
//                    'id' => $types->id,
//                    'name' => $types->name,
//                    'levelOne' => $levels[0]['levelName'],
//                    'levelTwo' => $levels[1]['levelName'],
//                    'levelThree' => $levels[2]['levelName'],
//                    'levelFour' => $levels[3]['levelName'],
//                    'levelFive' => $levels[4]['levelName'],
//                    'levelSix' => $levels[5]['levelName'],
//                    'levelSeven' => $levels[6]['levelName'],
//                    'levelEight' => $levels[7]['levelName'],
//                    'updated_at' => $types->updated_at
//                ];
//            }
//        }
//        $leaveRequestData = [ 'data' => $data  ];
//
//        return $leaveRequestData;
//    }

    /**
     * @param Request $request
     * @return ApprovalFlowLevelResource|ApprovalFlowLevel|JsonResponse
     */
    public function store(Request $request)
    {
//        return $request;
        $result = $this->approvalFlowLevel->storeResource($request);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
