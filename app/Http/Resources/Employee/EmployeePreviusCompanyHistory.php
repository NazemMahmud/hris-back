<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeePreviusCompanyHistory extends JsonResource
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
            'division' => $this->division,
            'department' => $this->department,
            'unit' => $this->unit,
            'job_level' => $this->job_level,
            'salary_formula' => $this->salary_formula,
            'salary' => $this->salary,
            'tax_deducation' => $this->tax_deducation,
            'pF_deduction' => $this->pF_deduction,
            'start_date' => $this->start_date,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
