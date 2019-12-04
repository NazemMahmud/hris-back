<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\OrganizationUnitCollection;
use App\Models\Setup\OrganizationUnit;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\OrganizationUnit as OrganizationUnitResource;

class OrganizationUnitController extends Controller
{
    /**
     * @var OrganizationUnit
     */
    private $organizationUnit;

    function __construct(OrganizationUnit $organizationUnit)
    {
        $this->organizationUnit = $organizationUnit;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return organizationUnitCollection
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
        return new organizationUnitCollection($this->organizationUnit->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return OrganizationUnitResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->organizationUnit->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationUnitResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrganizationUnitResource
     */
    function show($id)
    {
        $result = $this->organizationUnit->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationUnitResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|OrganizationUnitResource
     */
    function update(Request $request, $id)
    {
        $result = $this->organizationUnit->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationUnitResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|OrganizationUnitResource
     */
    public function destroy($id)
    {
        $result = $this->organizationUnit->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationUnitResource($result);
    }

    public function searchResult($searchBy)
    {
        return new OrganizationUnitCollection($this->organizationUnit->searchResource($searchBy));
    }
}