<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeSublocationCollection;
use App\Http\Resources\Setup\EmployeeSublocation as EmployeeSublocationResource;
use App\Models\Setup\EmployeeSublocation;
use Illuminate\Http\JsonResponse;


class EmployeeSublocationController extends Controller
{
    /**
     * @var EmployeeSublocation
     */
    private $employeeSublocation;

    public function __construct(EmployeeSublocation $employeeSublocation)
    {
        $this->employeeSublocation = $employeeSublocation;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EmployeeSublocationCollection
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
        return new EmployeeSublocationCollection($this->employeeSublocation->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EmployeeSublocationResource
     */
    public function store(Request $request)
    {
        $result = $this->employeeSublocation->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeSublocationResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeSublocationResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->employeeSublocation->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeSublocationResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EmployeeSublocationResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeSublocation->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeSublocationResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EmployeeSublocationResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeSublocation->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeSublocationResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EmployeeSublocationCollection( $this->employeeSublocation->searchResource($searchBy));
    }
}
