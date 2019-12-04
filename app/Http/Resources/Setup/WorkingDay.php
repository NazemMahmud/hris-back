<?php

namespace App\Http\Resources\Setup;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingDay extends JsonResource
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
            'type' => $this->type,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
