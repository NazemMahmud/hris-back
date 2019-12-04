<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeUnitCollection;
use App\Http\Resources\Setup\EmployeeUnit as EmployeeUnitResource;
use App\Models\Setup\EmployeeUnit;
use Illuminate\Http\JsonResponse;


class EmployeeUnitController extends Controller
{
    /**
     * @var EmployeeUnit
     */
    private $employeeUnit;

    public function __construct(EmployeeUnit $employeeUnit)
    {
        $this->employeeUnit = $employeeUnit;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeUnitCollection
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
        return new EmployeeUnitCollection($this->employeeUnit->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeUnitResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeUnit->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeUnitResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeUnitResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeUnit->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeUnitResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeUnitResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeUnit->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeUnitResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeUnitResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeUnit->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeUnitResource($result);
    }

    public function searchResult($searchBy)
    {
        return new employeeUnitCollection( $this->employeeUnit->searchResource($searchBy));
    }
    public function getEmployeeunit($employeeId){
        return $this->employeeUnit->getEmployeeunit($employeeId);
    }
}
