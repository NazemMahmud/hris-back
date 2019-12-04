<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\OrganizationDepartmentCollection;
use App\Models\Setup\OrganizationDepartment;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\OrganizationDepartment as OrganizationDepartmentResource;

class OrganizationDepartmentController extends Controller
{
    /**
     * @var OrganizationDepartment
     */
    private $organizationDepartment;

    function __construct(OrganizationDepartment $organizationDepartment)
    {
        $this->organizationDepartment = $organizationDepartment;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return organizationDepartmentCollection
     */
    function index(Request $request)
    {
        $orderBy = 'DESC';
         if($request->orderBy) {
             $orderBy = $request->orderBy;
         }
        if($request->searchBy)
        {
            return $this->searchResult($request->searchBy);
        }
        return new organizationDepartmentCollection($this->organizationDepartment->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return OrganizationDepartmentResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->organizationDepartment->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDepartmentResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrganizationDepartmentResource
     */
    function show($id)
    {
        $result = $this->organizationDepartment->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDepartmentResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|OrganizationDepartmentResource
     */
    function update(Request $request, $id)
    {
        $result = $this->organizationDepartment->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDepartmentResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|OrganizationDepartmentResource
     */
    public function destroy($id)
    {
        $result = $this->organizationDepartment->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDepartmentResource($result);
    }

    public function searchResult($searchBy)
    {
        return new organizationDepartmentCollection($this->organizationDepartment->searchResource($searchBy));
    }
}