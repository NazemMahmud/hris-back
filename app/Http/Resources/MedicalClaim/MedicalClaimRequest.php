<?php

namespace App\Http\Resources\MedicalClaim;

use App\Models\MedicalSetup\TreatmentMode;
use App\Models\Setup\Hospital;
use App\Models\Setup\Relationship;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MedicalClaim\MedicalClaimRequest as MedicalClaimRequestModel;
class MedicalClaimRequest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'medical_claim_items' => MedicalClaimRequestModel::where('deleted_at',null)->where('id',$this->id)->first()->medicalClaimItem,
            'employee_name' => $this->employee_name,
            'organization_name' =>$this->organization_name,
            'designation' =>$this->designation,
            'patient_name' =>$this->patient_name,
            'relationship_name' => Relationship::select('name')->where('id',$this->relationship_id)->first()?
            Relationship::select('name')->where('id',$this->relationship_id)->first()->name:null,
            'hospital_name' =>Hospital::select('name')->where('id',$this->hospital_id)->first()?
            Hospital::select('name')->where('id',$this->hospital_id)->first()->name:null,
            'treatment_mode_name' => TreatmentMode::select('name')->where('id',$this->treatment_mode_id)->first()?
            TreatmentMode::select('name')->where('id',$this->treatment_mode_id)->first()->name:null,
            'claimed_amount' => $this->claimed_amount,
            'settled_amount' => $this->settled_amount,
            'mobile_number' =>$this->mobile_number,
            'cause_for_admission' =>$this->cause_for_admission,
            'admission_date' =>$this->admission_date,
            'isActive' =>$this->isActive,
            'isDefault' =>$this->isDefault,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
