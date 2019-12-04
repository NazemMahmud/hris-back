<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee\EmployeeDeceasedInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EmployeeDeceasedInfoController extends Controller
{

    private $employeeDeceasedInfo;

    public function __construct(EmployeeDeceasedInfo $employeeDeceasedInfo)
    {
        $this->employeeDeceasedInfo = $employeeDeceasedInfo;
    }

    public function index(Request $request)
    {
        return $this->employeeDeceasedInfo->getAll($request->pageSize);
    }

    public function store(Request $request)
    {
        $date = date("Y-m-d");
        return $this->employeeDeceasedInfo->storeResource(18, $date);
    }

    public function update(Request $request, $id)
    {
        return $this->employeeDeceasedInfo->getDataCollection($this->employeeDeceasedInfo->updateResource($request, $id));
    }

    public function destroy($id)
    {
        return $this->employeeEngagementAndCultureList->deleteResource($id);
    }

//    public function searchResult($searchBy)
//    {
//        return new EmployeeEngagementAndCultureListCollection($this->employeeEngagementAndCultureList->searchResource($searchBy));
//    }
}
