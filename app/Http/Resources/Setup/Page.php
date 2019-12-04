<?php

namespace App\Http\Resources\Setup;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Permission\GroupPermission;

class Page extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
       /* if( $this->groupId){
            $checked = GroupPermission::Where("group_id", $this->groupId)
                ->where("page_id", $this->id)
                ->pluck("isChecked");
    
            $permission = GroupPermission::Where("group_id", $this->groupId)
                ->where("page_id", $this->id)
                ->pluck("permission");

                return [
                    'id' => $this->id,
                    'groupId' => $this->groupId,
                    'name' => $this->name,
                    'description' => $this->description,
                    'isChecked' => $checked[0],
                    'permission' => $permission[0],
                ];
        } */

        return [
            'id' => $this->id,
            'name' => $this->name,
            'link'=> $this->link,
            'parent_id'=>$this->parent_id,
            'translate' => $this->translate,
            'type' => $this->type,
            'icon' => $this->icon,
            'badge' => $this->badge,
            'isActive'=>$this->isActive,
            'isDefault'=>$this->isDefault
        ];
    }
}
