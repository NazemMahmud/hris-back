<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\MaritalStatusCollection;
use App\Models\Setup\MaritalStatus;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\MaritalStatus as MaritalStatusResource;


class MaritalStatusController extends Controller
{
    /**
     * @var MaritalStatus
     */
    private $maritalStatus;

    function __construct(MaritalStatus $maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return MaritalStatusCollection
     */
    function index(Request $request)
    {
        $orderBy = 'DESC';
        
        if($request->orderBy) {
            $orderBy = $request->orderBy;
        }
        if($request->searchBy)
        {
            return  $this->searchResult($request->searchBy);
        }
        return new MaritalStatusCollection($this->maritalStatus->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return MaritalStatusResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->maritalStatus->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new MaritalStatusResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return MaritalStatusResource
     */
    function show($id)
    {
        $result = $this->maritalStatus->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new MaritalStatusResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|MaritalStatusResource
     */
    function update(Request $request, $id)
    {
        $result = $this->maritalStatus->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new MaritalStatusResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|MaritalStatusResource
     */
    public function destroy($id)
    {
        $result = $this->maritalStatus->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new MaritalStatusResource($result);
    }

    public function searchResult($searchBy) 
    {
        return  new MaritalStatusCollection( $this->maritalStatus->searchResource($searchBy));
    }
}