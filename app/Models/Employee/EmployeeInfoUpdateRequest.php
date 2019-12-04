<?php

namespace App\Models\Employee;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EmployeeInfoUpdateRequest extends Base
{
    public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }

    public function employeeInfoPendingUpdateRequest($staff_id)
    {
        return EmployeeInfoUpdateRequest::where('staff_id',$staff_id)->where('status',0)->first();
    }
    public function employeeInfoHistoryUpdateRequest($staff_id)
    {
        return EmployeeInfoUpdateRequest::where('staff_id',$staff_id)->where('status','>',0)->first();
    }

    public function getEmployeeInfo($staff_id)
    {
        return EmployeeInfoUpdateRequest::where('staff_id',$staff_id)->first();
    }
}
