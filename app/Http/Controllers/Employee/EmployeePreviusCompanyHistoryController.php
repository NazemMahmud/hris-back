<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeePreviusCompanyHistoryCollection;
use App\Http\Resources\Employee\EmployeePreviusCompanyHistory as EmployeePreviusCompanyHistoryResource;
use App\Models\Employee\EmployeePreviusCompanyHistory;
use Illuminate\Http\JsonResponse;


class EmployeePreviusCompanyHistoryController extends Controller
{
    /**
     * @var EmployeePreviusCompanyHistory
     */
    private $employeePreviusCompanyHistory;

    public function __construct(EmployeePreviusCompanyHistory $employeePreviusCompanyHistory)
    {
        $this->employeePreviusCompanyHistory = $employeePreviusCompanyHistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return EmployeePreviusCompanyHistoryCollection
     */
    public function index()
    {
        return new EmployeePreviusCompanyHistoryCollection($this->employeePreviusCompanyHistory->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeePreviusCompanyHistoryResource
     */
    public function store(Request $request)
    {
        $result = $this->employeePreviusCompanyHistory->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeePreviusCompanyHistoryResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeePreviusCompanyHistoryResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeePreviusCompanyHistory->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeePreviusCompanyHistoryResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeePreviusCompanyHistoryResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeePreviusCompanyHistory->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeePreviusCompanyHistoryResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeePreviusCompanyHistoryResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeePreviusCompanyHistory->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeePreviusCompanyHistoryResource($result);
    }
}
