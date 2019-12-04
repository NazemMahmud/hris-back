<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\DayCareCollection;
use App\Http\Resources\Employee\DayCare as DayCareResource;
use App\Repositories\Employee\DayCareRepository;


class DayCareController extends Controller
{

    private $dayCareRepository;

    public function __construct(DayCareRepository $dayCareRepository)
    {
        $this->dayCareRepository = $dayCareRepository;
    }

    public function index(Request $request)
    {
        return new DayCareCollection($this->dayCareRepository->all($request));
    }

    public function store(Request $request)
    {
        $result = $this->dayCareRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new DayCareResource($result);
    }

    public function show($id)
    {
        $result = $this->dayCareRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new DayCareResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->dayCareRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new DayCareResource($result);
    }

    public function destroy($id)
    {
        $result = $this->dayCareRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new DayCareResource($result);
    }

    public function employeesChildrenInDaycare($staff_id)
    {
        $result = $this->dayCareRepository->childrenInDayCare($staff_id);
       if(count($result)==0){
            return response()->json(['errors' => 'Resource not found'], 404);
       }
        return  new DayCareCollection(($result));
    }

    public function daycareClaimEligibility($staff_id){

        return $result = $this->dayCareRepository->daycareClaimEligibility($staff_id);
    }
    public function DayCareRequestStore(Request $request){
        return $result = $this->dayCareRepository->DayCareRequestStore($request);
    }

}
