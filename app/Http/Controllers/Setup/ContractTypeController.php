<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\ContractTypeCollection;
use App\Http\Resources\Setup\ContractType as ContractTypeResource;
use App\Models\Setup\ContractType;
use Illuminate\Http\JsonResponse;


class ContractTypeController extends Controller
{
    /**
     * @var ContractType
     */
    private $contractType;

    public function __construct(ContractType $contractType)
    {
        $this->contractType = $contractType;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ContractTypeCollection
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
        return new ContractTypeCollection($this->contractType->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ContractTypeResource
     */
    public function store(Request $request)
    {
        $result = $this->contractType->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractTypeResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ContractTypeResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->contractType->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractTypeResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return ContractTypeResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->contractType->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractTypeResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ContractTypeResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->contractType->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractTypeResource($result);
    }

    public function searchResult($searchBy)
    {
        return new ContractTypeCollection($this->contractType->searchResource($searchBy));
    }
}
