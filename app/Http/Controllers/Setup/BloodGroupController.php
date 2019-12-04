<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Setup\BloodGroupCollection;
use App\Http\Resources\Setup\BloodGroup as BloodGroupResource;
use App\Models\Setup\BloodGroup;
use Illuminate\Http\JsonResponse;

class BloodGroupController extends Controller
{
    private $BloodGroup;

    function __construct(BloodGroup $BloodGroup)
    {
        $this->BloodGroup = $BloodGroup;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return BloodGroupCollection
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
            return  $this->searchResult($request->searchBy);
        }
        return new BaseCollection($this->BloodGroup->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return BloodGroup|BloodGroupResource
     */
    public function store(Request $request)
    {
        $result = $this->BloodGroup->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new BloodGroupResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return BloodGroupResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->BloodGroup->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BloodGroupResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return BloodGroupResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->BloodGroup->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new BloodGroupResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return BloodGroupResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->BloodGroup->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BloodGroupResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new BloodGroupCollection( $this->BloodGroup->searchResource($searchBy));
    }
}
