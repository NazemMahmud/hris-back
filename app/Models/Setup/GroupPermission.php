<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\Setup\Page as PageResource;
use App\Manager\RedisManager\RedisManager;
use Illuminate\Support\Facades\Validator;

class GroupPermission extends Model
{

    function storeResource($requestFrom, $pageOrGroupid)
    {
        // for temporary purpose
        $groupId = 0;

        if($requestFrom == 'page') $parentModel = Group::all();
        else $parentModel = Page::all();
        $pageCache = RedisManager::DynamicMenuCacher();
        foreach ($parentModel as $model)
        {
            $groupPermission = new GroupPermission();
            if($requestFrom == 'page')
            {
                $groupId = $model->id;
                if($pageCache->exists($groupId)) {
                    $pageCache->delete($groupId);
                }
                $groupPermission->group_id = $model->id;
                $groupPermission->page_id = $pageOrGroupid;
            }else{
                $groupId = $pageOrGroupid;
                $groupPermission->group_id = $pageOrGroupid;
                $groupPermission->page_id = $model->id;
            }
            ($groupId == 4) ? $groupPermission->isChecked = 1 : $groupPermission->isChecked = 0;
            $groupPermission->permission = 'readonly';
            $groupPermission->created_by = Auth::user()->staff_id;
            $groupPermission->updated_by = Auth::user()->staff_id;
            $groupPermission->save();
        }
    }

   /* function deleteResource($requestFrom, $pageOrGroupid)
    {
        if($requestFrom == 'page') $resource = GroupPermission::where('page_id', $pageOrGroupid)->get();
        else   $resource = GroupPermission::where('group_id', $pageOrGroupid)->get();

//        if (empty($resource)) return response()->json(['message' => 'Resource not found.'], 404);

        if($resource->link) app('App\Models\Setup\GroupPermission')->storeResource('page', $resource->id);
        $resource->delete();

        return $resource;
    } */


}

