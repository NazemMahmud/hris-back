<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeDivisionCollection;
use App\Http\Resources\Setup\EmployeeDivision as EmployeeDivisionResource;
use App\Models\Setup\EmployeeDivision;
use Illuminate\Http\JsonResponse;

class EmployeeDivisionController extends Controller
{
    /**
     * @var EmployeeDivision
     */
    private $employeeDivision;

    public function __construct(EmployeeDivision $employeeDivision)
    {
        $this->employeeDivision = $employeeDivision;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeDivisionCollection
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
        return new EmployeeDivisionCollection($this->employeeDivision->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeDivisionResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeDivision->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDivisionResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeDivisionResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeDivision->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDivisionResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeDivisionResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeDivision->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDivisionResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeDivisionResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeDivision->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeDivisionResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeDivisionCollection( $this->employeeDivision->searchResource($searchBy));
    }
}
