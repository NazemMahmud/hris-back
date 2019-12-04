<?php

namespace App\Http\Resources\Setup;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Setup\Bank;
use App\Models\Setup\Band;

class EmployeeInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $info = $data['info']?$data['info']:$data;
        $requestedData = $data['request'];

        return [
            'id' => $info->id,
            'staff_id' => $info->staff_id,
            'employee_type' => $info->employee_type,
            'designation_id' => $info->designation_id,
            'employee_org_id' => $info->employee_org_id,
            'access_card_no' => $info->access_card_no,
            'org_division_id' => $info->org_division_id,
            'org_department_id' => $info->org_department_id,
            'org_unit_id' => $info->org_unit_id,
            'location_id' => $info->location_id,
            'subLocation_id' => $info->subLocation_id,
            'jobLevel_id' => $info->jobLevel_id,
            'lineManager_1st' => $info->lineManager_1st,
            'lineManager_2nd' => $info->lineManager_2nd,
            'division_head' => $info->division_head,
            'hrbp' => $info->hrbp,
            'shiftType_id' => $info->shiftType_id,
            'joiningDate' => $info->joiningDate,
            'position_id' => $info->position_id,
            'employee_id' => $info->employee_id,
            'name' => $info->employeeName,
            'employment_date' => $info->employment_date,
            'employment_end_date' => $info->employment_end_date,
            'contract_type_id' => $info->contract_type_id,
            'contract_duration' => $info->contract_duration,
            'contract_end_date' => $info->contract_end_date,
            'bank_id' => $info->bank_id,
            'bank' => Bank::where('id',$info->bank_id)->first()?Bank::where('id',$info->bank_id)->first()->name:'',
            'band_id' => $info->band_id,
            'band' => Band::where('id',$info->band_id)->first()?Band::where('id',$info->band_id)->first()->name:'',
            'bank_account_no' => $info->bank_account_no,
            'bank_account_name' => $info->bank_account_name,
            'tax_responsible_id' => $info->tax_responsible_id,
            'payment_type_id' => $info->payment_type_id,
            'working_day_id' => $info->working_day_id,
            'employee_status_id' => $info->employee_status_id,
            'exit_date' => $info->exit_date,
            'exit_reason_id' => $info->exit_reason_id,
            'probation_end_date' => $info->probation_end_date,
            'created_at' => $info->created_at,
            'updated_at' => $info->updated_at,
            'requestedData'=>[
                'id' => $requestedData?$requestedData->id:'',
                'staff_id' => $requestedData?$requestedData->staff_id:'',
                'employee_type' => $requestedData?$requestedData->employee_type:'',
                'designation_id' => $requestedData?$requestedData->designation_id:'',
                'employee_org_id' => $requestedData?$requestedData->employee_org_id:'',
                'access_card_no' => $requestedData?$requestedData->access_card_no:'',
                'org_division_id' => $requestedData?$requestedData->org_division_id:'',
                'org_department_id' => $requestedData?$requestedData->org_department_id:'',
                'org_unit_id' => $requestedData?$requestedData->org_unit_id:'',
                'location_id' => $requestedData?$requestedData->location_id:'',
                'subLocation_id' => $requestedData?$requestedData->subLocation_id:'',
                'jobLevel_id' => $requestedData?$requestedData->jobLevel_id:'',
                'lineManager_1st' => $requestedData?$requestedData->lineManager_1st:'',
                'lineManager_2nd' => $requestedData?$requestedData->lineManager_2nd:'',
                'division_head' => $requestedData?$requestedData->division_head:'',
                'hrbp' => $requestedData?$requestedData->hrbp:'',
                'shiftType_id' => $requestedData?$requestedData->shiftType_id:'',
                'joiningDate' => $requestedData?$requestedData->joiningDate:'',
                'position_id' => $requestedData?$requestedData->position_id:'',
                'employee_id' => $requestedData?$requestedData->employee_id:'',
                'name' => $requestedData?$requestedData->employeeName:'',
                'employment_date' => $requestedData?$requestedData->employment_date:'',
                'employment_end_date' => $requestedData?$requestedData->employment_end_date:'',
                'contract_type_id' => $requestedData?$requestedData->contract_type_id:'',
                'contract_duration' => $requestedData?$requestedData->contract_duration:'',
                'contract_end_date' => $requestedData?$requestedData->contract_end_date:'',
                'bank_id' => $requestedData?$requestedData->bank_id:'',
                'bank' => $requestedData?Bank::where('id',$requestedData->bank_id)->first()?Bank::where('id',$requestedData->bank_id)->first()->name:'':'',
                'band_id' => $requestedData?$requestedData->band_id:'',
                'band' => $requestedData?Band::where('id',$requestedData->band_id)->first()?Band::where('id',$requestedData->band_id)->first()->name:'':'',
                'bank_account_no' => $requestedData?$requestedData->bank_account_no:'',
                'bank_account_name' => $requestedData?$requestedData->bank_account_name:'',
                'tax_responsible_id' => $requestedData?$requestedData->tax_responsible_id:'',
                'payment_type_id' => $requestedData?$requestedData->payment_type_id:'',
                'working_day_id' => $requestedData?$requestedData->working_day_id:'',
                'employee_status_id' => $requestedData?$requestedData->employee_status_id:'',
                'exit_date' => $requestedData?$requestedData->exit_date:'',
                'exit_reason_id' => $requestedData?$requestedData->exit_reason_id:'',
                'probation_end_date' => $requestedData?$requestedData->probation_end_date:'',
                'created_at' => $requestedData?$requestedData->created_at:'',
                'updated_at' => $requestedData?$requestedData->updated_at:'',
                'status' => $requestedData?$requestedData->status:'',
                'Accept_or_rejected_by' => $requestedData?$requestedData->Accept_or_rejected_by:'',
                'rejection_reason' => $requestedData?$requestedData->rejection_reason:'',
            ]
        ];
    }
}
