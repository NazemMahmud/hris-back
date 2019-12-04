<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeStatusCollection;
use App\Http\Resources\Setup\EmployeeStatus as EmployeeStatusResource;
use App\Models\Setup\EmployeeStatus;
use Illuminate\Http\JsonResponse;

class EmployeeStatusController extends Controller
{
    /**
     * @var EmployeeStatus
     */
    private $employeeStatus;

    function __construct(EmployeeStatus $employeeStatus)
    {
        $this->employeeStatus = $employeeStatus;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return EmployeeStatusCollection
     */
    public function index(Request $request)
    {
        if($request->searchBy)
        {
            return  $this->searchResult($request->searchBy);
        }
        $orderBy = 'DESC';
        if($request->orderBy)
        {
            $orderBy = $request->orderBy;
        }
        return $this->employeeStatus->getAll($request->pageSize, $orderBy);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return employeeStatus|EmployeeStatusResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeStatus->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeStatusResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return EmployeeStatusResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeStatus->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeStatusResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return EmployeeStatusResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeStatus->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeStatusResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return EmployeeStatusResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeStatus->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeStatusResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new EmployeeStatusCollection( $this->employeeStatus->searchResource($searchBy));
    }
}