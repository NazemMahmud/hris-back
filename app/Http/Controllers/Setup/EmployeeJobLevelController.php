<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeJobLevelCollection;
use App\Http\Resources\Setup\EmployeeJobLevel as EmployeeJobLevelResource;
use App\Models\Setup\EmployeeJobLevel;
use Illuminate\Http\JsonResponse;

class EmployeeJobLevelController extends Controller
{
    /**
     * @var EmployeeJobLevel
     */
    private $employeeJobLevel;

    function __construct(EmployeeJobLevel $employeeJobLevel)
    {
        $this->employeeJobLevel = $employeeJobLevel;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return employeeJobLevelCollection
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
        return $this->employeeJobLevel->getAll($request->pageSize, $orderBy);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return employeeJobLevel|EmployeeJobLevelResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeJobLevel->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeJobLevelResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return EmployeeJobLevelResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeJobLevel->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeJobLevelResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return EmployeeJobLevelResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeJobLevel->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeJobLevelResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return EmployeeJobLevelResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeJobLevel->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeJobLevelResource($result);
    }

    public function searchResult($searchBy)
    {
        return new employeeJobLevelCollection( $this->employeeJobLevel->searchResource($searchBy));
    }
    public function getEmployeejoblevel($employeeId){

        return $this->employeeJobLevel->getJobLevel($employeeId);
    }

}
