<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeExitReasonCollection;
use App\Http\Resources\Setup\EmployeeExitReason as EmployeeExitReasonResource;
use App\Models\Setup\EmployeeExitReason;
use Illuminate\Http\JsonResponse;

class EmployeeExitReasonController extends Controller
{
    /**
     * @var EmployeeExitReason
     */
    private $employeeExitReason;

    function __construct(EmployeeExitReason $employeeExitReason)
    {
        $this->employeeExitReason = $employeeExitReason;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return EmployeeExitReasonCollection
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
        return $this->employeeExitReason->getAll($request->pageSize, $orderBy);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return EmployeeExitReason|EmployeeExitReasonResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeExitReason->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeExitReasonResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return EmployeeExitReasonResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeExitReason->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeExitReasonResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return EmployeeExitReasonResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeExitReason->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeExitReasonResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return EmployeeExitReasonResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeExitReason->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeExitReasonResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new employeeExitReasonCollection( $this->employeeExitReason->searchResource($searchBy));
    }
}
