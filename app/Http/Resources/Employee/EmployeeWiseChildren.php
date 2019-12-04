<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeWiseChildren extends JsonResource
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
            'staffId' => $this->staff_id,
            'Name' => $this->name,
            'placeOfBirth' => $this->place_of_birth,
            'dob' => $this->dob,
            'genderId' => $this->gender_id,
            'status' => $this->status,
            'createdBy' => $this->created_by,
            'placeName'=> $this->placeName,
            'childrenGender' => $this->childrenGender,
            'updatedBy' => $this->updated_by,
            'deletedBy' => $this->deleted_by,
            'isDefault' => $this->isDefault,
            'isActive' => $this->isActive,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
