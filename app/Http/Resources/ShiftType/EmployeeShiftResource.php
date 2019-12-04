<?php

namespace App\Http\Resources\ShiftType;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeShiftResource extends JsonResource
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
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
        ];
    }
}
