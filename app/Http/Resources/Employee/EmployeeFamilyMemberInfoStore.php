<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeFamilyMemberInfoStore extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'full_name' => $this->full_name,
            'full_name_bangla' => $this->full_name_bangla,
            'gender_id' => $this->gender_id,
            'phone_no' => $this->phone_no,
            'nid' => $this->nid,
            'birth_certification_no' => $this->birth_certification_no,
            'spouse_position' => $this->spouse_position,
            'spouse_position' => $this->spouse_position,
            'spouse_company' => $this->spouse_company,
            'spouse_phone_no' => $this->spouse_phone_no,
            'spouse_occupation' => $this->spouse_occupation,
            'spouse_phone_no' => $this->spouse_phone_no,
            'spouse_occupation' => $this->spouse_occupation,
            'spouse_national_id' => $this->spouse_national_id,
            'spouse_dob' => $this->spouse_dob,
            'spouse_name' => $this->spouse_name,
            'employee_mother_name' => $this->employee_mother_name,
            'employee_mother_dob' => $this->employee_mother_dob,
            'employee_mother_occupation_id' => $this->employee_mother_occupation_id,
            'employee_mother_phone_no' => $this->employee_mother_phone_no,
            'employee_mother_address' => $this->employee_mother_address,
            'employee_father_name' => $this->employee_father_name,
            'employee_father_dob' => $this->employee_father_dob,
            'employee_father_occupation_id' => $this->employee_father_occupation_id,
            'employee_father_phone_no' => $this->employee_father_phone_no,
            'employee_father_address' => $this->employee_father_address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
