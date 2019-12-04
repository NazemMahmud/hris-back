<?php

namespace App\Http\Resources\ApprovalFlow;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalFlowLevel extends JsonResource
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
            'approval_flow_type_id' =>$this->approval_flow_type_id,
            'level' =>$this->level,
            'isDefault' => $this->isDefault,
            'isActive' => $this->isActive
        ];
    }
}
