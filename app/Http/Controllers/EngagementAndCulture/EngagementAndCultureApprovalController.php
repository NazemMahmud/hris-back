<?php

namespace App\Http\Controllers\EngagementAndCulture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Models\Employee\EmployeeDeceasedInfo;

class EngagementAndCultureApprovalController extends Controller
{
    protected $employeeDeceasedInfo;

    function __construct(EmployeeDeceasedInfo $employeeDeceasedInfo)
    {
        $this->employeeDeceasedInfo = $employeeDeceasedInfo;
    }

    public function index(Request $request)
    {
        return $this->employeeDeceasedInfo->getAllDeceasedInfo();
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $result = $this->employeeDeceasedInfo->getResourceById($id);
        return $result;
    }

    public function update(Request $request, $id)
    {
        $result = $this->employeeDeceasedInfo->updateDeceasedStatus($request, $id);
        return $result;
    }

    public function destroy($id)
    {
        //
    }
}
