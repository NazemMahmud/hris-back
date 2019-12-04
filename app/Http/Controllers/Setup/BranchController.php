<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\BranchCollection;
use App\Http\Resources\Setup\Branch as BranchResource;
use App\Models\Setup\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;

class BranchController extends Controller
{
    /**
     * @var Branch
     */
    private $branch;

    function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return BranchCollection
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
        return new BaseCollection($this->branch->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BranchResource|JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->branch->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new BranchResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BranchResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->branch->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BranchResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return BranchResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->branch->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new BranchResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return BranchResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->branch->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BranchResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new BranchCollection( $this->branch->searchResource($searchBy));
    } 
}
