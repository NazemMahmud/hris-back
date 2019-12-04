<?php

namespace App\Models\MedicalClaim;

use App\Events\GenericRedisEvent;
use App\Helpers\Helper;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalClaim\MedicalClaimItem;

class MedicalClaimRequest extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'employee_name' =>  'required',
            'organization_name' =>  'required',
            'designation' =>  'required',
            'patient_name' =>  'required',
            'relationship_id' =>  'required',
            'hospital_id' =>  'required',
            'treatment_mode_id' => 'required',
            'mobile_number' =>  'required',
            'cause_for_admission' =>  'required',
            'admission_date' =>  'required',
            'claimed_amount' =>  'required',
            'nature_of_illness' =>  'required',
            'hospital_address' =>  'required',
            'name_of_doctor' =>  'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new MedicalClaimRequest();
        $staff_id = Auth::user()?Auth::user()->staff_id:null;
        $resource->employee_name = $request->employee_name;
        $resource->medical_claim_number = $this->GetMedicalClaimNumber($staff_id);
        $resource->organization_name = $request->organization_name;
        $resource->designation = $request->designation;
        $resource->patient_name = $request->patient_name;
        $resource->relationship_id = $request->relationship_id;
        $resource->hospital_id = $request->hospital_id;
        $resource->treatment_mode_id = $request->treatment_mode_id;
        $resource->claimed_amount = $request->claimed_amount;
        $resource->settled_amount = $request->settled_amount;
        $resource->mobile_number = $request->mobile_number;
        $resource->cause_for_admission = $request->cause_for_admission;
        $resource->admission_date =Helper::formatdateTime($request->admission_date);
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;
        $resource->created_by = $request->created_by;
        $resource->updated_by = $request->updated_by;
        $resource->deleted_by = $request->deleted_by;
        $resource->status = $request->status;
        $resource->nature_of_illness = $request->nature_of_illness;
        $resource->hospital_address = $request->hospital_address;
        $resource->name_of_doctor = $request->name_of_doctor;
        $resource->prescribed_by_doctor = $request->prescribed_by_doctor;
        $resource->has_original_money_receipt_of_doctor = $request->has_original_money_receipt_of_doctor;
        $resource->has_original_itemized_pharmacy_bill = $request->has_original_itemized_pharmacy_bill;
        $resource->has_photocopy_of_physicians_prescription = $request->has_photocopy_of_physicians_prescription;
        $resource->original_receipt_of_each_lab_test = $request->original_receipt_of_each_lab_test;

        $resource->save();
       // event(new GenericRedisEvent($resource));

        return $resource;
    }
    public function GetMedicalClaimNumber($staff_id){
        return $staff_id.''.substr(number_format(time() * rand(),0,'',''),0,6);;
    }

        function updateResource($request, $id)
        {
            $resource = MedicalClaimRequest::find($id);

            if (empty($resource)) return response()->json(['message' => 'Resource not Found'], 404);
            $validator = Validator::make($request->all(),
            [
                'settled_amount' => 'required',
            ]);
            if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

            $resource->settled_amount = $request->settled_amount;
            $resource->save();
            event(new GenericRedisEvent($resource));
            return $resource;
        }

        public function medicalClaimItem()
        {
            return $this->hasMany('App\Models\MedicalClaim\MedicalClaimItem','medical_claim_request_id', 'id');
        }
}
