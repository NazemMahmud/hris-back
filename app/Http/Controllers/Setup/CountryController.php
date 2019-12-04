<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Setup\CountryCollection;
use App\Models\Setup\Country;
use \App\Http\Resources\Setup\Country as CountryResource;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $country;

    /**
     * CountryController constructor.
     * @param Country $country
     */
    function __construct(Country $country)
    {
        $this->country = $country;
    }

    /**
     * @param Request $request
     * @return CountryCollection
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
        return new BaseCollection($this->country->getAll($request->pageSize, $orderBy));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $result = $this->country->createResource();
        return (is_object(json_decode($result))) === false ?  $result :  new CountryResource($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
     function store(Request $request)
    {
        $result = $this->country->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new CountryResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $result = $this->country->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new CountryResource($result);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->country->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new CountryResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = $this->country->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new CountryResource($result);
    }
    
    public function searchResult($searchBy) 
    {
        return new CountryCollection($this->country->searchResource($searchBy));
    }
}