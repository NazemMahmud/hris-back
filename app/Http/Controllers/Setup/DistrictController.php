<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\DistrictCollection;
use App\Http\Resources\Setup\District as DistrictResource;
use App\Models\Setup\District;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;

class DistrictController extends Controller
{
    /**
     * @var District
     */
    private $district;

    /**
     * DistrictController constructor.
     * @param District $district
     */
    function __construct(District $district)
    {
        $this->district = $district;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return DistrictCollection
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
        if($request->divisionId)
        {
            return $this->searchDivision($request->divisionId);
        }
        
        return new BaseCollection($this->district->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return DistrictResource|JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->district->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new DistrictResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return DistrictResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->district->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new DistrictResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return DistrictResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->district->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new DistrictResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return DistrictResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->district->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new DistrictResource($result);
    }

    public function searchResult($searchBy)
    {
        return new DistrictCollection( $this->district->searchResource($searchBy));
    }

    public function searchDivision($divisionId)
    {
        return new DistrictCollection( $this->district->searchDivisionId($divisionId));
    }
}