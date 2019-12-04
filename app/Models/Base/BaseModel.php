<?php

namespace App\Models\Base;

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\Base;
use App\Enums\Approval\ApprovalStatusEnum;
use App\Models\ApprovalFlow\ApprovalFlowType;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use Illuminate\Support\Facades\Auth;

/**
 * @author Fazlul Kabir Shohag <shohag.fks@gmail.com>
 */

class BaseModel extends Base
{
    public function __construct(Model $model){
        $this->model = $model;
    }

    function storeResource($request) {
        $EntityModel = $this->model;
        $fields = $EntityModel::PostSerializerFields();

        $validator = Validator::make($request->all(), $EntityModel::FieldsValidator());

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new $EntityModel();
        $createCommonFields = Fields::createCommonFields($fields, $resource);
        $resource = $createCommonFields['resource'];
        $fields = $createCommonFields['fields'];

        foreach ($fields as $field) {
            $resource->$field = $request->$field;
        }

        $resource->save();
        return $resource;
    }

    function updateResource($request, $id)
    {
        $EntityModel = $this->model;
        $fields = $EntityModel::PostSerializerFields();
        $resource = $EntityModel::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), $EntityModel::FieldsValidator());
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        foreach ($fields as $field) {
            $resource->$field = $request->$field;
        }
        $resource->save();
        return $resource;
    }

    // Will make a trait class for using below methods
    public function storeApprovalRequest($modelInstance, $levelName, $relatedFields)
    {
        $flowType = ApprovalFlowType::where('name', 'like', "%{$levelName}%")->first();
        $flowLevel = ApprovalFlowLevel::where('approval_flow_type_id',  $flowType->id)->first();
        $staffId = Auth::user()->staff_id;
        $newRequest = $modelInstance;
        $newRequest->current_level = $flowLevel->id;
        $newRequest->status = StatusEnum::Pending()->getValue(); 
        $newRequest->approved_by = $this->getApprovedBy($flowLevel->level, $staffId);
        foreach($relatedFields as $databaseField => $value) {
            $newRequest->$databaseField = $value;
        }
        $newRequest->created_by = $staffId; 
        $newRequest->updated_by = $staffId;

        $newRequest->save();
    }

    public function isApprovalAuthorize($relatedFields, $staffId): bool {
        $approvalProcess = $this->model::where($relatedFields[0], $relatedFields[1])
        ->select('approved_by')->orderBy('id', 'desc')->first();
        if(!empty($approvalProcess) && $approvalProcess->approved_by == $staffId) {
            return true;
        } else {
            return false;
        }
    }

    public function getCurrentApproveLevel($relatedField, $travelId) {
        $level = $this->model::where($relatedField, $travelId)->orderBy('id', 'desc')->first();
        return $level;
    }

    public function ParentRequestApproved($model, $relatedField): void {
        $travel = $model::where('id', $relatedField)->first();
        $travel->status = ApprovalStatusEnum::Accepted()->getValue();
        $travel->save();
    }

    public function ParentRequestRejected($model, $relatedField): void {
        $rejectTravelRequest = $model::where('id', '=', $relatedField)->first();
        $rejectTravelRequest->status = ApprovalStatusEnum::Rejected()->getValue();
        $rejectTravelRequest->save();
    }

    public function getApprovedBy($level, $staffId) {
        if($level == 'first_line_manager') {
            return EmployeeGenericInfo::getFirstLineManagerId($staffId);
        } else if($level == 'second_line_manager') {
            return EmployeeGenericInfo::getSecondtLineManagerId($staffId);
        } else if($level == 'hrbp') {
            return EmployeeGenericInfo::getHrbpId($staffId);
        } else {
            return (int) $level;
        }
    }

    public function findNextLevel($levels, $current_level) {
        foreach($levels as $index => $level) {
            if($level->id == $current_level) {
                if(isset($levels[$index + 1]) && $levels[$index + 1]) {
                    return $levels[$index + 1];
                }
            }
        }
        return false;
    }
}
