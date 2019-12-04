<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class Requisition extends JsonResource
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
            'job_title' => $this->job_title,
            'reporting_to' => $this->reporting_to,
            'job_level_id' => $this->job_level_id,
            'division_id' => $this->division_id,
            'department_id' => $this->department_id,
            'shift_type_id' => $this->shift_type_id,
            'gender_id' => $this->gender_id,
            'replacement_id' => $this->replacement_id,
            'request_type' => $this->request_type,
            'expected_hiring_date' => $this->expected_hiring_date,
            'contract_type' => $this->contract_type,
            'contract_duration' => $this->contract_duration,
            'description' => $this->description,
            'description_file' => $this->description_file,
            'status' => $this->status,
            'educational_qualification' =>$this->educational_qualification,
            'additional_requirement' =>$this->additional_requirement,
            'job_location' =>$this->job_location,
            'line_managed_id' => $this->line_managed_id,
            'unit_id' => $this->unit_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
