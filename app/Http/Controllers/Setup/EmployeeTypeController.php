<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeTypeCollection;
use App\Http\Resources\Setup\EmployeeType as EmployeeTypeResource;
use App\Models\Setup\EmployeeType;
use Illuminate\Http\JsonResponse;

class EmployeeTypeController extends Controller
{
    /**
     * @var EmployeeType
     */
    private $employeeType;

    public function __construct(EmployeeType $employeeType)
    {
        $this->employeeType = $employeeType;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeTypeCollection
     */
    public function index(Request $request)
    {
        $orderBy ='DESC';
        if($request->orderBy)
        {
            $orderBy = $request->orderBy;
        }
        if($request->searchBy)
        {
            return $this->searchResult($request->searchBy);
        }
        return new EmployeeTypeCollection($this->employeeType->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeTypeResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeType->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeTypeResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeTypeResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeType->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeTypeResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeTypeResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeType->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeTypeResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeTypeResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeType->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeTypeResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeTypeCollection( $this->employeeType->searchResource($searchBy));
    }
}
