<?php

namespace App\Models\Employee;

use http\Env\Request;
use App\Models\Base;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Setup\Division;
use App\Models\Setup\EmployeeDepartment;
use App\Models\ShiftType\ShiftType;
use App\Models\Setup\Gender;
use App\Models\Setup\ContractType;
use App\Models\Setup\ContractDuration;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\RequisitionApprovedRequest;
class Requisition extends Base
{
    protected $fillable = [
        'job_title',
        'reporting_to', 'job_level_id', 'division_id', 'department_id', 'shift_type_id',
        'gender_id', 'replacement_id', 'request_type', 'expected_hiring_date', 'contract_type',
        'contract_duration', 'description', 'description_file', 'status', 'created_by' ,'unit_id' ,
        'updated_by', 'deleted_by'
    ];

    public function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {

        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'shift_type_id' => 'required',
            'request_type' => 'required',
            'expected_hiring_date' => 'required',
            'contract_type' => 'required',
            'created_by' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);

        $resource = new Requisition();
        $resource->job_title = $request->job_title;
        $resource->shift_type_id = $request->shift_type_id;
        $resource->request_type = $request->request_type;
        $resource->contract_type = $request->contract_type;

        if($request->has('job_level_id')){
            $resource->job_level_id = $request->job_level_id;
        }
        if($request->has('contract_duration')){
            $resource->contract_duration = $request->contract_duration;
        }
        if($request->has('division_id')){
            $resource->division_id = $request->division_id;
        }
        if($request->has('department_id')){
            $resource->department_id = $request->department_id;
        }
        if($request->has('gender_id')){
            $resource->gender_id = $request->gender_id;
        }
        if($request->has('replacement_id')){
            $resource->replacement_id = $request->replacement_id;
        }
        if($request->has('description')){
            $resource->description = $request->description;
        }
        if($request->has('status')){
            $resource->status = $request->status;
        }
        if($request->has('created_by')){
            $resource->created_by = $request->created_by;
        }
        if($request->has('educational_qualification')){
            $resource->educational_qualification = $request->educational_qualification;
        }
        if($request->has('additional_requirement')){
            $resource->additional_requirement = $request->additional_requirement;
        }
        if($request->has('job_location')){
            $resource->job_location = $request->job_location;
        }
        if($request->has('line_managed_id')){
            $resource->line_managed_id = $request->line_managed_id;
        }
        if($request->has('line_managed_id')){
            $resource->line_managed_id = $request->line_managed_id;
        }
        if($request->has('unit_id')){
            $resource->line_managed_id = $request->unit_id;
        }

        $resource->expected_hiring_date = Helper::formatdate($request->expected_hiring_date);

        $resource->reporting_to = $resource->created_by;
        $hrbp = $this->checkIfHRBP($resource->created_by);
        if ($hrbp==true) {
             $resource->status = 1;
        }

        $resource->save();

        $approvalRequest = new RequisitionApprovedRequest();
        $approvalRequest->requisition_request_id = $resource->id;
        if ($hrbp==true) {
            $approvalRequest->userLevel_id = $resource->created_by;
            $approvalRequest->status = 1;
        }
        $approvalRequest->save();

        return $resource;
    }
    public function checkIfHRBP($employeeId){
        $employeeInfo = EmployeeInfo::where('hrbp',$employeeId)->get();
        return count($employeeInfo)>0?true:false;
    }
    function updateResource($request, $id)
    {
        $resource = Requisition::where('id', '=', $id)->first();

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'shift_type_id' => 'required',
            'request_type' => 'required',
            'expected_hiring_date' => 'required',
            'contract_type' => 'required',
            'created_by' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);

        $resource->job_title=$request->job_title;
        $resource->shift_type_id=$request->shift_type_id;
        $resource->request_type=$request->request_type;
        $resource->contract_type=$request->contract_type;

        if($request->has('contract_duration')){
            $resource->contract_duration = $request->contract_duration;
        }
        if($request->has('job_level_id')){
            $resource->job_level_id = $request->job_level_id;$resource->job_level_id = $request->job_level_id;
        }
        if($request->has('division_id')){
            $resource->division_id = $request->division_id;
        }
        if($request->has('department_id')){
            $resource->department_id = $request->department_id;
        }
        if($request->has('gender_id')){
            $resource->gender_id = $request->gender_id;
        }
        if($request->has('replacement_id')){
            $resource->replacement_id = $request->replacement_id;
        }
        if($request->has('description')){
            $resource->description = $request->description;
        }
        if($request->has('status')){
            $resource->status = $request->status;
        }
        if($request->has('created_by')){
            $resource->created_by = $request->created_by;
        }
        if($request->has('educational_qualification')){
            $resource->educational_qualification = $request->educational_qualification;
        }
        if($request->has('additional_requirement')){
            $resource->additional_requirement = $request->additional_requirement;
        }
        if($request->has('job_location')){
            $resource->job_location = $request->job_location;
        }
        if($request->has('line_managed_id')){
            $resource->line_managed_id = $request->line_managed_id;
        }
        if($request->has('unit_id')){
            $resource->line_managed_id = $request->unit_id;
        }
        $hrbp = $this->checkIfHRBP($resource->created_by);
        if ($hrbp==true) {
             $resource->status = 1;
        }

        $resource->expected_hiring_date = Helper::formatdate($request->expected_hiring_date);

        $resource->save();

        return $resource;
    }
    public function employeeRequisition($employeeId){

        $datas['data'] = Requisition::where('created_by',$employeeId)->get();

        foreach ($datas['data'] as $key => $data){
            $data['divisionName'] = '';
            $data['department'] = '';
            if ($data->division_id){
                $division = Division::where('id',$data->division_id)->select('name')->first();
                $data['divisionName'] = !empty($division->name)?$division->name:'';
            }
            if ($data->department_id){
                $department = EmployeeDepartment::where('id',$data->department_id)->select('name')->first();
                $data['department'] = !empty($department->name)?$department->name:'';
            }
            if ($data->shift_type_id){
                $shift_type= ShiftType::where('id',$data->shift_type_id)->select('name')->first();
                $data['shift_type'] = !empty($shift_type->name)?$shift_type->name:'';
            }
            if ($data->gender_id){
                $gender= Gender::where('id',$data->gender_id)->select('name')->first();
                $data['gender'] = !empty($gender->name)?$gender->name:'';
            }
            if ($data->contract_type){
                $contract_type = ContractType::where('id',$data->contract_type)->select('name')->first();
                $data['contractTypeName'] = !empty($contract_type->name)?$contract_type->name:'';
            }
            if ($data->contract_duration){
                $contractDuration = ContractDuration::where('id',$data->contract_duration)->select('number_of_month')->first();
                $data['contractDurationName'] = !empty($contractDuration->number_of_month)?$contractDuration->number_of_month:'';
            }
        }
        if (!empty($datas['data'])){
            return $datas['data'];
        }
        return response()->json(['errors' => 'Resource not found'], 404);

    }

    function employeeRequisitionRequest($request, $id)
    {

        if(empty($id)){
            return response()->json(['errors' => 'please input requisition id'], 404);
        }
        $resource = Requisition::where('id', '=', $id)->first();
        $RequisitionApprovedRequest = RequisitionApprovedRequest::where('requisition_request_id', '=', $id)->first();
        if(empty($resource) || empty($RequisitionApprovedRequest)){
            return response()->json(['errors' => 'Resource not found'], 404);
        }
        if($request->has('status')){
            $resource->status = $request->status;
            if ($request->status==1){
                $RequisitionApprovedRequest->status = "1";
            }
            if ($request->status==2){
                $RequisitionApprovedRequest->status = "2";
            }
            if ($request->status==0){
                $RequisitionApprovedRequest->status = "0";
            }

        }
        if($request->has('rejection_reason')){
            $resource->rejection_reason = $request->rejection_reason;
        }
        if($request->has('Accept_or_rejected_by')){
            $resource->Accept_or_rejected_by = $request->Accept_or_rejected_by;
            $RequisitionApprovedRequest->userLevel_id = $request->Accept_or_rejected_by;
        }
        $RequisitionApprovedRequest->save();
        $resource->save();

        return $resource;
    }

    function getEmployeeRequisitionRequestData($employeeId)
    {
        $employeeinfo = EmployeeInfo::where('hrbp',$employeeId)->select('staff_id')->get();
        if ($employeeinfo){
            foreach($employeeinfo as $Empinfo){
                $datas['data'] = Requisition::where('created_by',$Empinfo->staff_id)->get();
                if ($datas['data']){
                    foreach ($datas['data'] as $key => $data){
                    $data['divisionName'] = '';
                    $data['department'] = '';
                    if ($data->division_id){
                        $division = Division::where('id',$data->division_id)->select('name')->first();
                        $data['divisionName'] = !empty($division->name)?$division->name:'';
                    }
                    if ($data->department_id){
                        $department = EmployeeDepartment::where('id',$data->department_id)->select('name')->first();
                        $data['department'] = !empty($department->name)?$department->name:'';
                    }
                    if ($data->shift_type_id){
                        $shift_type= ShiftType::where('id',$data->shift_type_id)->select('name')->first();
                        $data['shift_type'] = !empty($shift_type->name)?$shift_type->name:'';
                    }
                    if ($data->gender_id){
                        $gender= Gender::where('id',$data->gender_id)->select('name')->first();
                        $data['gender'] = !empty($gender->name)?$gender->name:'';
                    }
                    if ($data->contract_type){
                        $contract_type = ContractType::where('id',$data->contract_type)->select('name')->first();
                        $data['contractTypeName'] = !empty($contract_type->name)?$contract_type->name:'';
                    }
                    if ($data->contract_duration){
                        $contractDuration = ContractDuration::where('id',$data->contract_duration)->select('number_of_month')->first();
                        $data['contractDurationName'] = !empty($contractDuration->number_of_month)?$contractDuration->number_of_month:'';
                        }
                    }
                    if (!empty($datas['data'])){
                        return $datas['data'];
                    }
                }
            }
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }
}
