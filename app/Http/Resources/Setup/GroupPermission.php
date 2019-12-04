<?php

namespace App\Http\Resources\Setup;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Setup\Page as PageResource;

class GroupPermission extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'pages' => PageResource::collection(Page::all()),
            'isChecked' => $this->isChecked,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
