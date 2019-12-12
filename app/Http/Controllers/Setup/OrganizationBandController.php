<?php

namespace App\Http\Controllers\Setup;

use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\OrganizationBandCollection;
use App\Models\Setup\OrganizationBand;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\OrganizationBand as OrganizationBandResource;

class OrganizationBandController extends Controller
{
    /**
     * @var OrganizationBand
     */
    private $organizationBand;
    private $employee;

    function __construct(OrganizationBand $organizationBand, Employee $employee)
    {
        $this->organizationBand = $organizationBand;
//        $this->employee = $employee;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return OrganizationBandCollection
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
        return new OrganizationBandCollection($this->organizationBand->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return OrganizationBandResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->organizationBand->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationBandResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrganizationBandResource
     */
    function show($id)
    {
        $result = $this->organizationBand->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationBandResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|OrganizationBandResource
     */
    function update(Request $request, $id)
    {
        $result = $this->organizationBand->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationBandResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|OrganizationBandResource
     */
    public function destroy($id)
    {
        $result = $this->organizationBand->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new OrganizationBandResource($result);
    }

    public function searchResult($searchBy)
    {
        return new OrganizationBandCollection($this->organizationBand->searchResource($searchBy));
    }
}
