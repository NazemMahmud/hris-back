<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeDepartmentCollection;
use App\Http\Resources\Setup\EmployeeDepartment as EmployeeDepartmentResource;
use App\Models\Setup\EmployeeDepartment;
use Illuminate\Http\JsonResponse;


class EmployeeDepartmentController extends Controller
{
    /**
     * @var EmployeeDepartment
     */
    private $employeeDepartment;

    public function __construct(EmployeeDepartment $employeeDepartment)
    {
        $this->employeeDepartment = $employeeDepartment;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeDepartmentCollection
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
        return new EmployeeDepartmentCollection($this->employeeDepartment->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeDepartmentResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeDepartment->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDepartmentResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeDepartmentResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeDepartment->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDepartmentResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeDepartmentResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeDepartment->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDepartmentResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeDepartmentResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeDepartment->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDepartmentResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeDepartmentCollection( $this->employeeDepartment->searchResource($searchBy));
    }

    public function getByDivision(Request $request){
        return new EmployeeDepartmentCollection($this->employeeDepartment->getByColumnName($request->divisionId, 'division_id'));
    }
    public function getDepartmentByDivision($department_id){
        $result = $this->employeeDepartment->departmentByDivision($department_id);
        return (is_object($result)) ?  $result :  new EmployeeDepartmentResource($result);
    }


}
