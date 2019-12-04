<?php

namespace App\Models\Employee;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyMemberInfoUpdateRequest extends Base
{
    public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }
    public function employeeFamilyMemberInfoUpdateRequest($staff_id)
    {
        return EmployeeFamilyMemberInfoUpdateRequest::where('staff_id',$staff_id)->where('status',0)->first();
    }
    public function employeeFamilyMemberInfoHistoryUpdateRequest($staff_id)
    {
        return EmployeeFamilyMemberInfoUpdateRequest::where('staff_id',$staff_id)->where('status','>',0)->first();
    }

    public function getEmployeeFamilyMemberInfo($staff_id)
    {
        return EmployeeFamilyMemberInfoUpdateRequest::where('staff_id',$staff_id)->first();
    }
}
