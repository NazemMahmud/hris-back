<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveApprovalRequests extends JsonResource
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
            'id' =>$this->id,
            'leaveRequestId' =>$this->leaveRequestId,
            'userLeavelId' =>$this->userLeavelId,
            'status' =>$this->status,
            'isDefault' => $this->isDefault,
            'isActive' => $this->isActive
        ];
    }
}
