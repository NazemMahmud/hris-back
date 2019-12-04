<?php

namespace App\Http\Resources\SpecialChildrenBenefit;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialChildren extends JsonResource
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
            'date_of_birth' => date('Y-m-d', strtotime($this->staff_id)),
            'gender' => $this->gender->name,
        ];
    }
}
