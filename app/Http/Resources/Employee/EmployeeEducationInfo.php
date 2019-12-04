<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEducationInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'education_level' => $this->education_level,
            'institution_name' => $this->institution_name,
            'country' => $this->country,
            'graduation_year' => $this->graduation_year,
            'result' => $this->result,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
