<?php

namespace App\Http\Resources\Setup;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveType extends JsonResource
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
            'maximumdays' => $this->maximumdays,
            'iarryForwardDayAnnually' => $this->iarryForwardDayAnnually,
            'includedWithAnnualLeave' => $this->includedWithAnnualLeave,
            'isDefault' => $this->isDefault,
            'isActive' => $this->isActive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
