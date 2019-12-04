<?php

namespace App\Http\Resources\SpecialChildrenBenefit;

use App\Models\Employee\EmployeeChildrenInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialChildrenForEmployee extends JsonResource
{
    function __construct(EmployeeChildrenInfo $model)
    {
        parent::__construct($model);
    }

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
        ];
    }
}
