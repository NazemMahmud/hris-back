<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\PositionCollection;
use App\Models\Setup\Position;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\Position as PositionResource;

class PositionController extends Controller
{
    /**
     * @var Position
     */
    private $position;

    function __construct(Position $position)
    {
        $this->position = $position;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return PositionCollection
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
        return new PositionCollection($this->position->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return PositionResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->position->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new PositionResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PositionResource
     */
    function show($id)
    {
        $result = $this->position->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new PositionResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|PositionResource
     */
    function update(Request $request, $id)
    {
        $result = $this->position->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new PositionResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|PositionResource
     */
    public function destroy($id)
    {
        $result = $this->position->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new PositionResource($result);
    }

    public function searchResult($saerchBy)
    {
        return new PositionCollection( $this->position->searchResource($saerchBy));
    }
}
