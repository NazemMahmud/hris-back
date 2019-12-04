<?php

namespace App\Http\Resources\MedicalClaim;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalClaimItem extends JsonResource
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
            'receipt_description' => $this->receipt_description,
            'requested_amount' => $this->requested_amount,
            'settled_amount' => $this->settled_amount,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
