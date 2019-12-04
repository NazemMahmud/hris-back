<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Http\Request;
use App\Models\Employee\dayCare;
use App\Models\Employee\BasicInfo;
use App\Models\Employee\EmployeeChildrenInfo;
use Carbon\Carbon;
/**
 * Class PaymentTypeReposatory.
 */
class DayCareRepository
{
    private $dayCare;

    public function __construct(dayCare $dayCare)
    {
        $this->dayCare = $dayCare;
    }

    public function all($request)
    {
        return $this->dayCare->getAllStoredData($request);
    }

    public function store(Request $data)
    {
        return $this->dayCare->storeResource($data);
    }

    // update record in the database
    public function update(Request $data, $id)
    {
        return $this->dayCare->updateResource($data, $id);
    }

    public function show( $id)
    {
        return $this->dayCare->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->dayCare->deleteResource($id);
    }
    public function daycareClaimEligibility($staff_id)
    {
        $gender = $this->CheckIfWomen($staff_id);
        $sitExit = $this->dayCare->checkIfDayCareHasSit();
        $eligibleChildren = $this->hasEligibleChildrenToApply($staff_id);
        return $this->ConditionalResponse($gender,$sitExit,$eligibleChildren);
    }

    public function ConditionalResponse($gender,$sitExit,$eligibleChildren){
        if ($gender==0){
            return response()->json(['error' => 'Only female can apply for DayCare'], 200);
        }
        if ($sitExit>20){
            return response()->json(['error' => 'Twenty sit in DayCare is fill-up'], 200);
        }
        if ($eligibleChildren==0){
            return response()->json(['error' => 'You can only apply for children more than six month to lower then six year'], 200);
        }
        if ($gender==1 && $sitExit<21 && $eligibleChildren!=0){
            return response()->json(['message' => 'eligible to Apply'], 200);
        }
        return response()->json(['error' => 'not eligible for DayCare'], 200);
    }
    public function CheckIfWomen($staff_id){
        $gender = BasicInfo::where('employee_basic_info.staff_id', $staff_id)
            ->join('genders', 'employee_basic_info.genderId', '=', 'genders.id')
            ->select('genders.name')->first();

        if (!empty($gender)){
            if ($gender->name =='F' || $gender->name =='Female' || $gender->name=='female' || $gender->name =='f'){
                return 1;
            }
        }
        return 0;

    }

    public function hasEligibleChildrenToApply($staff_id){

       $sixMonthEarly = date('Y-m-d', strtotime("-6 months"));
       $sixYearEarly = date('Y-m-d', strtotime("-6 years"));
       return EmployeeChildrenInfo::where('staff_id',$staff_id)->whereBetween('dob', [$sixYearEarly, $sixMonthEarly])->count();

    }
    public function DayCareRequestStore($request){
        $dayCareResource = $this->dayCare::find($request->id);
        if ($dayCareResource){
            $request->has('accept_or_rejected_by')?$dayCareResource->accept_or_rejected_by=$request->accept_or_rejected_by:null;
            $request->has('rejection_reason')?$dayCareResource->rejection_reason=$request->rejection_reason:null;
            $request->has('status')?$dayCareResource->status=$request->status:null;
            $dayCareResource->save();
            return response()->json(['message' => 'Updated'], 200);
        }
        return response()->json(['message' => 'Resource not found'], 404);
    }
    public function childrenInDayCare($staffId){

        $resource= $this->dayCare::where('staff_id',$staffId)->get();
        return $resource;
    }
}
