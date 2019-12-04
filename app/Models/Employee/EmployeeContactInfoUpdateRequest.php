<?php

namespace App\Models\Employee;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EmployeeContactInfoUpdateRequest extends Base
{
     public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }

    public function employeeContactRequested($staff_id)
    {
        return EmployeeContactInfoUpdateRequest::where('staff_id',$staff_id)->where('status',0)->first();
    }
    public function employeeContactHistoryRequested($staff_id)
    {
        return EmployeeContactInfoUpdateRequest::where('staff_id',$staff_id)->where('status','>',0)->first();
    }
    public function employeeContactInfoRequested($staff_id)
    {
        return  EmployeeContactInfoUpdateRequest::where('staff_id',$staff_id)->first();
    }
}
