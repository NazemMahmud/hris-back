<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\RoleCollection;
use App\Models\Setup\Role;
use Illuminate\Http\JsonResponse;
use \App\Http\Resources\Setup\Role as RoleResource;


class RoleController extends Controller
{
    /**
     * @var Role
     */
    private $role;

    function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RoleCollection
     */
    function index(Request $request)
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
        return new RoleCollection($this->role->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RoleResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->role->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new RoleResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return RoleResource
     */
    function show($id)
    {
        $result = $this->role->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new RoleResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|RoleResource
     */
    function update(Request $request, $id)
    {
        $result = $this->role->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new RoleResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|RoleResource
     */
    public function destroy($id)
    {
        $result = $this->role->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new RoleResource($result);
    }

    public function searchResult($searchBy)
    {
        return new RoleCollection( $this->role->searchResource($searchBy));
    }
}