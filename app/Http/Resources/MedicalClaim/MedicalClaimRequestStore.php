<?php

namespace App\Http\Resources\MedicalClaim;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalClaimRequestStore extends JsonResource
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
            'employee_name' => $this->employee_name,
            'medical_claim_number' => $this->medical_claim_number,
            'organization_name' => $this->organization_name,
            'designation' => $this->designation,
            'patient_name' => $this->patient_name,
            'relationship_id' => $this->relationship_id,
            'hospital_id' => $this->hospital_id,
            'treatment_mode_id' => $this->treatment_mode_id,
            'mobile_number' => $this->mobile_number,
            'cause_for_admission' => $this->cause_for_admission,
            'admission_date' => $this->admission_date,
            'claimed_amount' => $this->claimed_amount,
            'nature_of_illness' => $this->nature_of_illness,
            'hospital_address' => $this->hospital_address,
            'name_of_doctor' => $this->name_of_doctor,

        ];
    }
}
