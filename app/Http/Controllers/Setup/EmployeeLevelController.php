<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeLevelCollection;
use App\Http\Resources\Setup\EmployeeLevel as EmployeeLevelResource;
use App\Models\Setup\EmployeeLevel;
use Illuminate\Http\JsonResponse;


class EmployeeLevelController extends Controller
{
    /**
     * @var EmployeeLevel
     */
    private $employeeLevel;

    public function __construct(EmployeeLevel $employeeLevel)
    {
        $this->employeeLevel = $employeeLevel;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeLevelCollection
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
        return new EmployeeLevelCollection($this->employeeLevel->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeLevelResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeLevel->storeResource($request);
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
        $result = $this->employeeLevel->getResourceById($id);
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
        $result = $this->employeeLevel->updateResource($request, $id);
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
        $result = $this->employeeLevel->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeLevelResource($result);
    }
    public function searchResult($searchBy)
    {
        return new EmployeeLevelCollection( $this->employeeLevel->searchResource($searchBy));
    }
}
