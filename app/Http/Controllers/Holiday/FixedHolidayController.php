<?php

namespace App\Http\Controllers\Holiday;

use App\Http\Resources\Holiday\FixedHolidayCollection;
use App\Http\Resources\Holiday\FixedHoliday as FixedHolidayResource;
use App\Models\Holiday\FixedHoliday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixedHolidayController extends Controller
{
    private $fixedHoliday;

    public function __construct(FixedHoliday $fixedHoliday)
    {
        $this->fixedHoliday = $fixedHoliday;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FixedHolidayCollection
     */
    public function index()
    {
        return new FixedHolidayCollection($this->fixedHoliday->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return FixedHolidayCollection
     */
    public function show($id)
    {
        $result =  $this->fixedHoliday->getResource($id) ;
        return (is_object(json_decode($result))) === false ?  $result :  new FixedHolidayCollection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return FixedHolidayResource
     */
    public function store(Request $request)
    {
        $result = $this->fixedHoliday->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new FixedHolidayResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return FixedHolidayResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->fixedHoliday->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new FixedHolidayResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse|FixedHolidayResource
     */
    public function destroy($id)
    {
        $result = $this->fixedHoliday->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new FixedHolidayResource($result);
    }
}