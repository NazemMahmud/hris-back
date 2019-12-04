<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeeEducationInfoCollection;
use App\Http\Resources\Employee\EmployeeEducationInfo as EmployeeEducationInfoResource;
use App\Models\Employee\EmployeeEducationInfo;
use Illuminate\Http\JsonResponse;


class EmployeeEducationInfoController extends Controller
{
    /**
     * @var EmployeeEducationInfo
     */
    private $employeeEducationInfo;

    public function __construct(EmployeeEducationInfo $employeeEducationInfo)
    {
        $this->employeeEducationInfo = $employeeEducationInfo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return EmployeeEducationInfoCollection
     */
    public function index()
    {
        return new EmployeeEducationInfoCollection($this->employeeEducationInfo->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeEducationInfoResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeEducationInfo->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeEducationInfoResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeEducationInfoResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeEducationInfo->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeEducationInfoResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeEducationInfoResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeEducationInfo->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeEducationInfoResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeEducationInfoResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeEducationInfo->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeEducationInfoResource($result);
    }
}
