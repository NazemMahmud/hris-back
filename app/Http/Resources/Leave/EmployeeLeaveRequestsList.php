<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLeaveRequestsList extends JsonResource
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
            'leaveTypeName' => $this->leaveTypeName,
            'employeeId' => $this->employeeId,
            'date_From' => $this->date_From,
            'date_To' => $this->date_To,
            'time_From' => $this->time_From,
            'time_To' => $this->time_To,
            'totalDurationDays' => $this->totalDurationDays,
            'delegateName' => $this->delegateName,
            'status' => $this->status,
            'statusComment' => $this->statusComment,
            'requestDate' => $this->created_at,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
            'updated_at' => $this->updated_at
        ];

    }
}
