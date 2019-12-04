<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\DivisionCollection;
use App\Http\Resources\Setup\Division as DivisionResource;
use App\Models\Setup\Division;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;

class DivisionController extends Controller
{
    /**
     * @var Division
     */
    private $division;

    /**
     * DivisionController constructor.
     * @param Division $division
     */
    function __construct(Division $division)
    {
        $this->division = $division;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return DivisionCollection
     */
    public function index(Request $request)
    { 
        $orderBy = 'DESC';
        if($request->orderBy) {
            $orderBy = $request->orderBy;
        }
       
        if($request->searchBy)
        {
            return  $this->searchResult($request->searchBy);
        }
        
        //  $countryId;
        if($request->countryId)
        {
            return $this->searchCountryResult($request->countryId);
            
        }
        // dd($country_Id);
        return new BaseCollection($this->division->getAll($request->pageSize, $orderBy));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return DivisionResource|Division
     */
    public function store(Request $request)
    {
        $result = $this->division->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new DivisionResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return JsonResponse|DivisionResource
     */
    public function show($id)
    {
        $result = $this->division->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new DivisionResource($result);

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return DivisionResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->division->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new DivisionResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return DivisionResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->division->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new DivisionResource($result);
    }

    public function searchResult($searchBy)
    {
        return new DivisionCollection( $this->division->searchResource($searchBy));
    }

    public function searchCountryResult($countryId)
    {
        return new DivisionCollection( $this->division->searchCountryId($countryId));
    }
}
