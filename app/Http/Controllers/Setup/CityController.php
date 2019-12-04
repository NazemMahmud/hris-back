<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\CityCollection;
use App\Http\Resources\Setup\City as CityResource;
use App\Models\Setup\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;

class CityController extends Controller
{
    /**
     * @var City
     */
    private $city;

    function __construct(City $city)
    {
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return CityCollection
     */
    public function index(Request $request)
    {
        if($request->searchBy)
        {
            return  $this->searchResult($request->searchBy);
        }
        $orderBy = 'DESC';
        if($request->orderBy)
        {
            $orderBy = $request->orderBy;
        }
        return new BaseCollection($this->city->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return City|CityResource
     */
    public function store(Request $request)
    {
        $result = $this->city->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new CityResource($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return CityResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->city->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new CityResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return CityResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->city->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new CityResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return CityResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->city->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new CityResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new CityCollection( $this->city->searchResource($searchBy));
    }
}