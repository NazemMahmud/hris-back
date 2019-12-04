<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Setup\BankCollection;
use App\Http\Resources\Setup\Bank as BankResource;
use App\Models\Setup\Bank;
use Illuminate\Http\JsonResponse;

class BankController extends Controller
{
    private $bank;

    public function __construct(Bank $bank)
    {
        $this->bank = $bank;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return BankCollection
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
        return new BaseCollection($this->bank->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BankResource
     */
    public function store(Request $request)
    {
       $result = $this->bank->storeResource($request);
       return (is_object(json_decode($result))) === false ?  $result :  new BankResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BankResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->bank->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BankResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return BankResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->bank->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new BankResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return BankResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->bank->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BankResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new BankCollection( $this->bank->searchResource($searchBy));
    }
}
