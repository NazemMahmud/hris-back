<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeLocationCollection;
use App\Http\Resources\Setup\EmployeeLocation as EmployeeLevelResource;
use App\Models\Setup\EmployeeLocation;
use Illuminate\Http\JsonResponse;


class EmployeeLocationController extends Controller
{
    /**
     * @var EmployeeLocation
     */
    private $employeeLocation;

    public function __construct(EmployeeLocation $employeeLocation)
    {
        $this->employeeLocation = $employeeLocation;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeLocationCollection
     */
    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if($request->orderBy) 
        {
            $orderBy = $request->orderBy;
        }
        if($request->searchBy)
        {
            return $this->searchResult($request->searchBy);
        }
        return new EmployeeLocationCollection($this->employeeLocation->getAll($request->pageSize,$orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeLevelResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeLocation->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeLevelResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeLevelResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeLocation->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeLevelResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeLevelResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeLocation->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeLevelResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeLevelResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeLocation->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeLevelResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeLocationCollection( $this->employeeLocation->searchResource($searchBy));
    }
}
