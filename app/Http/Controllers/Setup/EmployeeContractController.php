<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeContractCollection;
use App\Http\Resources\Setup\EmployeeContract as EmployeeContractResource;
use App\Models\Setup\EmployeeContract;
use Illuminate\Http\JsonResponse;


class EmployeeContractController extends Controller
{
    /**
     * @var EmployeeContract
     */
    private $employeeContract;

    public function __construct(EmployeeContract $employeeContract)
    {
        $this->employeeContract = $employeeContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeContractCollection
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
        return new EmployeeContractCollection($this->employeeContract->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeContractResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeContract->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContractResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeContractResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeContract->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContractResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeContractResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeContract->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContractResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeContractResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeContract->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContractResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeContractCollection( $this->employeeContract->searchResource($searchBy));
    }
}
