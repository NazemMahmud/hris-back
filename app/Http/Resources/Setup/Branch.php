<?php

namespace App\Http\Resources\Setup;

use Illuminate\Http\Resources\Json\JsonResource;

class Branch extends JsonResource
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
            'address' => $this->address,
            'isHeadOffice' => $this->isHeadOffice,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
