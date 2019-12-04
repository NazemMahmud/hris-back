<?php

namespace App\Models\Employee;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeceasedApprovalRequest extends Base
{
    protected $table = "employee_deceased_approval_requests";
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request, $staffId)
    {
        $resource = new EmployeeDeceasedApprovalRequest();

        $employeeDeceasedInfo = EmployeeDeceasedInfo::select('$id')->where('$id', $emp_dece_id)->first();
        if($employeeDeceasedInfo)
        {
            $resource->emp_dece_id = $request->emp_dece_id;
        }
        $resource->enc_level_id = $request->enc_level_id;
        $resource->status = $request->status;
        $resource->next_level_id = $request->next_level_id;

        $resource->save();
        return $resource;
    }
    
}