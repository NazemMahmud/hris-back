<?php

namespace App\Http\Resources\ApprovalFlow;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalFlowType extends JsonResource
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
            'name' =>$this->name,
            'isDefault' => $this->isDefault,
            'isActive' => $this->isActive
        ];
    }
}
