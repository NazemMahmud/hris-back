<?php

namespace App\Http\Resources\MedicalClaim;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MedicalClaimItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => ['api-version' => '1.0']
        ];
    }
}
