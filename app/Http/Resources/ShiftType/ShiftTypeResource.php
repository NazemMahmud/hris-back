<?php

namespace App\Http\Resources\ShiftType;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftTypeResource extends JsonResource
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
            'name' => $this->name,
            'graceTime' => $this->graceTime,
            'daysOfWeek' => explode(",",json_decode($this->daysOfWeek)),
            'weekEnds' => explode(",",json_decode($this->weekEnds)),
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'lunchStartTime' => $this->lunchStartTime,
            'lunchEndTime' => $this->lunchEndTime,
            'startDate' =>$this->startDate,
            'endDate' => $this->endDate,
            'isActive' =>$this->isActive,
            'isDefault' =>$this->isDefault,
        ];
    }
}
