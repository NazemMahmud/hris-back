<?php

namespace App\Http\Resources\SpecialChildrenBenefit;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeInfoForSpecialChildrenCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
