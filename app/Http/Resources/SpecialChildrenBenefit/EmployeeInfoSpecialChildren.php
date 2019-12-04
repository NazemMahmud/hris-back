<?php

namespace App\Http\Resources\SpecialChildrenBenefit;

use App\Models\Employee\EmployeeInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeInfoSpecialChildren extends JsonResource
{

    function __construct(EmployeeInfo $model)
    {
        parent::__construct($model);
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'employee_name' => $this->employee->employeeName,
            'division_name' => $this->division->name,
            'department_name' => $this->department->name,
            'band_name' => isset($this->band->name) ? $this->band->name : '',
            'email' => $this->employee->user->email,
            'phone' => isset($this->employee->contact->phone_no_01) ? $this->employee->contact->phone_no_01 : '',
        ];
    }
}
