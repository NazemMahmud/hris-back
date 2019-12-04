<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\OrganizationDivisionCollection;
use App\Models\Setup\OrganizationDivision;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\OrganizationDivision as OrganizationDivisionResource;

class OrganizationDivisionController extends Controller
{
    /**
     * @var OrganizationDivision
     */
    private $organizationDivision;

    function __construct(OrganizationDivision $organizationDivision)
    {
        $this->organizationDivision = $organizationDivision;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return organizationDivisionCollection
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
        return new organizationDivisionCollection($this->organizationDivision->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return OrganizationDivisionResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->organizationDivision->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDivisionResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrganizationDivisionResource
     */
    function show($id)
    {
        $result = $this->organizationDivision->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDivisionResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|OrganizationDivisionResource
     */
    function update(Request $request, $id)
    {
        $result = $this->organizationDivision->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDivisionResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|OrganizationDivisionResource
     */
    public function destroy($id)
    {
        $result = $this->organizationDivision->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationDivisionResource($result);
    }

    public function searchResult($searchBy)
    {
        return new organizationDivisionCollection($this->organizationDivision->searchResource($searchBy));
    }
}
