<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Employee\EmployeeChildrenInfo;
use App\Models\Employee\Employee;
class DayCare extends JsonResource
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
            'Employee_name' =>Employee::find($this->staff_id) ? Employee::find($this->created_by)->employeeName:'',
            'children_id' => $this->children_id,
            'children_name'=> EmployeeChildrenInfo::find($this->children_id) ? EmployeeChildrenInfo::find($this->children_id)->name:'',
            'declaration' => $this->declaration,
            'justification' => $this->justification,
            'guardian_contract_number' => $this->guardian_contract_number,
            'guardian_name'=> $this->guardian_name,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'softDelete' => $this->softDelete,
            'isActive' => $this->isActive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
