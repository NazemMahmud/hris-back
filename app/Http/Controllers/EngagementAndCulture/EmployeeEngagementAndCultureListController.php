<?php

namespace App\Http\Controllers\EngagementAndCulture;

use App\Http\Resources\EngagementAndCulture\EmployeeEngagementAndCultureList as EngagementAndCultureResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EngagementAndCulture\EmployeeEngagementAndCultureList;
use App\Http\Resources\Base\BaseCollection;
//use App\Http\Resources\EngagementAndCulture\EmployeeEngagementAndCultureList as EmployeeEngagementAndCultureListResource;
use App\Http\Resources\EngagementAndCulture\EmployeeEngagementAndCultureListCollection;

class EmployeeEngagementAndCultureListController extends Controller
{
    private $employeeEngagementAndCultureList;

    public function __construct(EmployeeEngagementAndCultureList $employeeEngagementAndCultureList)
    {
        $this->employeeEngagementAndCultureList = $employeeEngagementAndCultureList;
    }

    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if ($request->orderBy) {
            $orderBy = $request->orderBy;
        }

        if ($request->searchBy) {
            return $this->searchResult($request->searchBy);
        }
        
//        return new BaseCollection($this->employeeEngagementAndCultureList->getAll($request->pageSize, $orderBy));
        return $this->employeeEngagementAndCultureList->getAll($request->pageSize, $orderBy);
    }

    public function store(Request $request)
    {
//        return new EngagementAndCultureResource($this->employeeEngagementAndCultureList->storeResource($request));
        return $this->employeeEngagementAndCultureList->storeResource($request);
    }

    public function show($id)
    {
        return $this->employeeEngagementAndCultureList->getResourceById($id);
    }

    public function destroy($id)
    {
        return $this->employeeEngagementAndCultureList->deleteResource($id);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeEngagementAndCultureListCollection($this->employeeEngagementAndCultureList->searchResource($searchBy));
    }
}
