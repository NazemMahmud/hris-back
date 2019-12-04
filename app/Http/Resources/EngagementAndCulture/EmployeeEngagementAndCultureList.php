<?php

namespace App\Http\Resources\EngagementAndCulture;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEngagementAndCultureList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        var_dump($this);
        return [
            'id' => $this['id'],
            'staff_id' => $this->staff_id,
//            'employee_name' => $this->employee_name
        ];
    }
}
