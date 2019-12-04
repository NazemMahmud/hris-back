<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeFamilyMemberInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $info = $data['info']?$data['info']:$data;
        $requestedData = $data['request'];

        return[
            'id' => $info->id,
            'staff_id' => $info->staff_id,
            'full_name' => $info->full_name,
            'full_name_bangla' => $info->full_name_bangla,
            'gender_id' => $info->gender_id,
            'phone_no' => $info->phone_no,
            'nid' => $info->nid,
            'birth_certification_no' => $info->birth_certification_no,
            'spouse_position' => $info->spouse_position,
            'spouse_position' => $info->spouse_position,
            'spouse_company' => $info->spouse_company,
            'spouse_phone_no' => $info->spouse_phone_no,
            'spouse_occupation' => $info->spouse_occupation,
            'spouse_phone_no' => $info->spouse_phone_no,
            'spouse_occupation' => $info->spouse_occupation,
            'spouse_national_id' => $info->spouse_national_id,
            'spouse_dob' => $info->spouse_dob,
            'spouse_name' => $info->spouse_name,
            'employee_mother_name' => $info->employee_mother_name,
            'employee_mother_dob' => $info->employee_mother_dob,
            'employee_mother_occupation_id' => $info->employee_mother_occupation_id,
            'employee_mother_phone_no' => $info->employee_mother_phone_no,
            'employee_mother_address' => $info->employee_mother_address,
            'employee_father_name' => $info->employee_father_name,
            'employee_father_dob' => $info->employee_father_dob,
            'employee_father_occupation_id' => $info->employee_father_occupation_id,
            'employee_father_phone_no' => $info->employee_father_phone_no,
            'employee_father_address' => $info->employee_father_address,
            'created_at' => $info->created_at,
            'updated_at' => $info->updated_at,
            'requestedData'=>[
                'id' => $requestedData?$requestedData->id:'',
                'staff_id' => $requestedData?$requestedData->staff_id:'',
                'family_member_info_id' => $requestedData?$requestedData->family_member_info_id:'',
                'full_name' => $requestedData?$requestedData->full_name:'',
                'full_name_bangla' => $requestedData?$requestedData->full_name_bangla:'',
                'gender_id' => $requestedData?$requestedData->gender_id:'',
                'phone_no' => $requestedData?$requestedData->phone_no:'',
                'nid' => $requestedData?$requestedData->nid:'',
                'birth_certification_no' => $requestedData?$requestedData->birth_certification_no:'',
                'spouse_position' => $requestedData?$requestedData->spouse_position:'',
                'spouse_position' => $requestedData?$requestedData->spouse_position:'',
                'spouse_company' => $requestedData?$requestedData->spouse_company:'',
                'spouse_phone_no' => $requestedData?$requestedData->spouse_phone_no:'',
                'spouse_occupation' => $requestedData?$requestedData->spouse_occupation:'',
                'spouse_phone_no' => $requestedData?$requestedData->spouse_phone_no:'',
                'spouse_occupation' => $requestedData?$requestedData->spouse_occupation:'',
                'spouse_national_id' => $requestedData?$requestedData->spouse_national_id:'',
                'spouse_dob' => $requestedData?$requestedData->spouse_dob:'',
                'spouse_name' => $requestedData?$requestedData->spouse_name:'',
                'employee_mother_name' => $requestedData?$requestedData->employee_mother_name:'',
                'employee_mother_dob' => $requestedData?$requestedData->employee_mother_dob:'',
                'employee_mother_occupation_id' => $requestedData?$requestedData->employee_mother_occupation_id:'',
                'employee_mother_phone_no' => $requestedData?$requestedData->employee_mother_phone_no:'',
                'employee_mother_address' => $requestedData?$requestedData->employee_mother_address:'',
                'employee_father_name' => $requestedData?$requestedData->employee_father_name:'',
                'employee_father_dob' => $requestedData?$requestedData->employee_father_dob:'',
                'employee_father_occupation_id' => $requestedData?$requestedData->employee_father_occupation_id:'',
                'employee_father_phone_no' => $requestedData?$requestedData->employee_father_phone_no:'',
                'employee_father_address' => $requestedData?$requestedData->employee_father_address:'',
                'created_at' => $requestedData?$requestedData->created_at:'',
                'updated_at' => $requestedData?$requestedData->updated_at:'',
                'status' => $requestedData?$requestedData->status:'',
                'Accept_or_rejected_by' => $requestedData?$requestedData->Accept_or_rejected_by:'',
                'rejection_reason' => $requestedData?$requestedData->rejection_reason:'',
            ]
        ];
    }
}
