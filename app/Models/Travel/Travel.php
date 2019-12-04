<?php

namespace App\Models\Travel;

use App\Enums\Approval\ApprovalStatusEnum;
use App\Models\Travel\TravelApprovalRequest;
use App\Enums\Approval\StatusEnum;
use App\Models\ApprovalFlow\ApprovalFlowType;
use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\GenericSolution\GenericModels\CommonOperation\EmployeeGenericInfo;
use App\GenericSolution\GenericModelFields\Fields;
use App\Models\Base\BaseModel;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Validator;
use App\Models\Travel\TravelAllowanceSetup;
use App\Utility\Clock;
use Auth;

class Travel extends BaseModel
{
    protected $table = "travels";

    public function __construct() 
    {
        parent::__construct($this);
    }

    public function type() {
        return $this->belongsTo('App\Models\Travel\TripType', 'trip_id', 'id')->select(array('id', 'name'));
    }

    public function purpose() {
        return $this->belongsTo('App\Models\Travel\TripPurpose', 'purpose_id', 'id')->select(array('id', 'name'));
    }

    public function reason() {
        return $this->belongsTo('App\Models\Travel\TripReason', 'reason_id', 'id')->select(array('id', 'name'));
    }

    public function mode() {
        return $this->belongsTo('App\Models\Travel\ModeOfTrip', 'mode_id', 'id')->select(array('id', 'name'));
    }

    public function country() {
        return $this->belongsTo('App\Models\Setup\Country', 'country_id', 'id')->select(array('id', 'name'));
    }

    public function approval() {
        $current_staff = Auth::user()->staff_id;
        return $this->belongsTo(TravelApprovalRequest::class, 'id', 'travel_id')->where('approved_by', $current_staff)->select(['id', 'travel_id', 'status', 'approved_by']);
    } 

    public function invoiceApproval() {
        $current_staff = Auth::user()->staff_id;
        return $this->belongsTo(TravelInvoiceApproval::class, 'id', 'travel_id')->where('approved_by', $current_staff)->select(['id', 'travel_id', 'travel_invoice_id', 'status', 'approved_by']);
    } 

    public function staff() {
        return $this->belongsTo(Employee::class, 'staff_id', 'id')->select(['id', 'employeeName']);
    } 


    public function getForeignKeyData() {
        return [
            'type', 'purpose', 'reason', 'mode', 'country'
        ];
    }

    public function SerializerFields()
    {
        return ['id', 'staff_id', 'start_dtime', 'end_dtime', 'trip_id', 
                'purpose_id', 'reason_id', 'mode_id', 'country_id', 
                'estimate_cost', 'destination', 'status', 'remark'
        ];
    }

    static public function PostSerializerFields()
    {
        return ['staff_id', 'start_dtime', 'end_dtime', 'trip_id', 
                'purpose_id', 'reason_id', 'mode_id', 'country_id', 
                'estimate_cost', 'destination', 'status', 'remark', 'created_by', 'updated_by', 'deleted_by'
        ];
    }

    static public function FieldsValidator()
    {
        return [
            'staff_id' => 'required',
            'start_dtime' => 'required',
            'end_dtime' => 'required',
            'trip_id' => 'required',
            'purpose_id' => 'required',
            'reason_id' => 'required',
            'country_id' => 'required',
            'mode_id' => 'required',
            'estimate_cost' => 'required',
            'destination' => 'required',
        ];
    }

    public function setHiddenFields()
    {
        return ['trip_id', 'purpose_id', 'reason_id', 'mode_id', 'country_id'];
    }

    public function totalFromPercentage($total, $percent) {
        return ($total * $percent) / 100;
    }

    public function getApprovedBy($level, $staffId) {
        if($level == 'first_line_manager') {
            return EmployeeGenericInfo::getFirstLineManagerId($staffId);
        } else if($level == 'second_line_manager') {
            return EmployeeGenericInfo::getSecondtLineManagerId($staffId);
        } else if($level == 'hrbp') {
            return EmployeeGenericInfo::getHrbpId($staffId);
        } else {
            return (int) $level;
        }
    }

    public function storeTravelApprovalRequest($travelId, $staffId)
    {
        $flowType = ApprovalFlowType::where('name', 'like', '%Travel%')->first();
        $flowLevel = ApprovalFlowLevel::where('approval_flow_type_id',  $flowType->id)->first();
        $newTravelRequest = new TravelApprovalRequest();
        $newTravelRequest->travel_id = $travelId;
        $newTravelRequest->level_id = $flowLevel->id;
        $newTravelRequest->status = StatusEnum::Pending()->getValue(); 
        $newTravelRequest->approved_by = $this->getApprovedBy($flowLevel->level, $staffId);
        $newTravelRequest->created_by = $staffId; 
        $newTravelRequest->updated_by = $staffId;

        $newTravelRequest->save();
    }

    function storeResource($request) {
        $EntityModel = $this->model;
        $fields = $EntityModel::PostSerializerFields();

        $validator = Validator::make($request->all(), $EntityModel::FieldsValidator());

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new $EntityModel();
        $createCommonFields = Fields::createCommonFields($fields, $resource);
        $resource = $createCommonFields['resource'];
        $fields = $createCommonFields['fields'];

        foreach ($fields as $field) {
            $resource->$field = $request->$field;
        }
        $resource->start_dtime = Clock::convertDateTime($request->start_dtime);
        $resource->end_dtime = Clock::convertDateTime($request->end_dtime);
        $resource->status = ApprovalStatusEnum::Pending()->getValue();
        $resource->save();
        
        // employee allowance calculation
        $band_id = EmployeeGenericInfo::getEmployeeBand($request->staff_id);
        if($band_id && !empty($band_id)) {
            $allowance = TravelAllowanceSetup::getAllowanceByBand($band_id);
            $diffTime = Clock::numberOfTimeBetweenDate($request->start_dtime, $request->end_dtime);
            $perMeals = ($allowance->total) / 3;
            $days = $diffTime['days'];
            $hours = $diffTime['hours'];

            $hourlyTotal = 0;
            if($hours < 8) {
                $hourlyTotal = $perMeals;
            } else if($hours < 16) {
                $hourlyTotal = $perMeals * 2;
            } else if($hours < 24) {
                $hourlyTotal = $perMeals * 3;
            }

            $employeeAllowance = new TravelAllowance();
            $employeeAllowance->travel_id = $resource->id;
            $employeeAllowance->breakfast_total = $this->totalFromPercentage($allowance->total, $allowance->breakfast) * $days + $hourlyTotal;
            $employeeAllowance->lunch_total = $this->totalFromPercentage($allowance->total, $allowance->lunch) * $days + $hourlyTotal;
            $employeeAllowance->dinner_total = $this->totalFromPercentage($allowance->total, $allowance->dinner) * $days + $hourlyTotal;
            $employeeAllowance->incidental_total = $this->totalFromPercentage($allowance->total, $allowance->incidental) * $days + $hourlyTotal;
            $employeeAllowance->created_by = $resource->staff_id;
            $employeeAllowance->updated_by = $resource->staff_id;
            $employeeAllowance->save();
        }

        //aproval request
        $this->storeTravelApprovalRequest($resource->id, $resource->staff_id);

        return $resource;
    }

    public function getTravelRequestData() {
        $Travelrequest = Travel::with('type', 'purpose', 'reason', 'mode', 'country', 'approval')->get();
        $Travelrequest->makeHidden(['trip_id', 'purpose_id', 'reason_id', 'mode_id', 'country_id']);

        $staff_id = Auth::user()->staff_id;
        $reponse = array();
        foreach($Travelrequest as $index => $approvalRequest) {
           if(isset($approvalRequest->approval->approved_by) && $approvalRequest->approval->approved_by == $staff_id) {
               $reponse[] = $approvalRequest;
            }
        }

        return $reponse; 
    }

    public function getTravelInvoiceRequestData() {
        $TravelInvoiceRequest = Travel::with('staff', 'type', 'purpose', 'reason', 'mode', 'country', 'invoiceApproval')->get();
        $TravelInvoiceRequest->makeHidden(['staff_id', 'trip_id', 'purpose_id', 'reason_id', 'mode_id', 'country_id']);

        $staff_id = Auth::user()->staff_id;
        $reponse = array();

        foreach($TravelInvoiceRequest as $approvalRequest) {
           if(isset($approvalRequest->invoiceApproval->approved_by) && $approvalRequest->invoiceApproval->approved_by == $staff_id) {
               $reponse[] = $approvalRequest;
            }
        }

        return $reponse; 
    }
}
