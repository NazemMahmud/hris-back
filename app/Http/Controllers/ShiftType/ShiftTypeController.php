<?php

namespace App\Http\Controllers\ShiftType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShiftType\ShiftType;
use App\Http\Resources\ShiftType\ShiftTypeResource;
use App\Http\Resources\ShiftType\ShiftTypeCollection;
use App\Models\Employee\EmployeeInfo;
use App\Http\Resources\ShiftType\EmployeeShiftResource;
class ShiftTypeController extends Controller
{
    private $ShiftType;
    private $employeeInfo;
    public function __construct(ShiftType $ShiftType,EmployeeInfo $employeeInfo)
    {
        $this->ShiftType = $ShiftType;
        $this->employeeInfo = $employeeInfo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return ShiftTypeResource::collection($this->ShiftType->getAll($request->query('pageSize'),$orderBy));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = $this->ShiftType->storeResource($request);

        return (is_object(json_decode($result))) === false ?  $result :  new ShiftTypeResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->ShiftType->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ShiftTypeResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->ShiftType->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new ShiftTypeResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->ShiftType->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ShiftTypeResource($result);
    }
    public function getShiftdetailsWithEmployeeId($employeeId)
    {
        $result = $this->employeeInfo->getEmployeeShiftinfo($employeeId);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeShiftResource($result);
    }
}
