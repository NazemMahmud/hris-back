<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Setup\BandCollection;
use App\Http\Resources\Setup\Band as BandResource;
use App\Manager\RedisManager\RedisManager;
use App\Models\Setup\Band;
use Illuminate\Http\JsonResponse;

class BandController extends Controller
{
    private $Band;

    function __construct(Band $Band)
    {
        $this->Band = $Band;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return BandCollection
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
        return new BaseCollection($this->Band->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Band|BandResource
     */
    public function store(Request $request)
    {
        $result = $this->Band->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new BandResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return BandResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->Band->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BandResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return BandResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->Band->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new BandResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return BandResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->Band->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BandResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new BandCollection( $this->Band->searchResource($searchBy));
    }
}
