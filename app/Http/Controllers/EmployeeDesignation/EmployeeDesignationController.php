<?php

namespace App\Http\Controllers\EmployeeDesignation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeDesignation\EmployeeDesignationCollection;
use App\Http\Resources\EmployeeDesignation\EmployeeDesignation as EmployeeDesignationResource;
use App\Models\Designation\EmployeeDesignation;

class EmployeeDesignationController extends Controller
{
    private $employeeDesignation;

    function __construct(EmployeeDesignation $employeeDesignation)
    {
        $this->employeeDesignation = $employeeDesignation;
    }
    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if($request->orderBy)
        {
            $orderBy = $request->orderBy;
        }

        if($request->searchBy)
        {
            return  $this->searchResult($request->searchBy);
        }
        return new EmployeeDesignationCollection($this->employeeDesignation->getAll($request->pageSize, $orderBy));
    }

    public function store(Request $request)
    {
        $result = $this->employeeDesignation->storeResource($request);
        return $result;
    }

    public function show($id)
    {
        $result = $this->employeeDesignation->getResourceById($id);
        // return $result;
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDesignationResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->employeeDesignation->updateResource($request, $id);
        return $result;
    }

    public function destroy($id)
    {
        $result = $this->employeeDesignation->deleteResource($id);
        return $result;
    }

    public function searchResult($searchBy) 
    {
        return new EmployeeDesignationCollection( $this->employeeDesignation->searchResource($searchBy));
    }
}
