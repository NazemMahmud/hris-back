<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\GroupCollection;
use App\Http\Resources\Setup\Group as GroupResource;
use App\Models\Setup\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * @var Group
     */
    private $group;

    function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return GroupCollection
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
        return new GroupCollection($this->group->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return GroupResource|JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->group->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new GroupResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return GroupResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->group->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new GroupResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return GroupResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->group->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new GroupResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return GroupResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->group->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new GroupResource($result);
    }

    public function searchResult($searchBy)
    {
        return new groupCollection( $this->group->searchResource($searchBy));
    }
}
