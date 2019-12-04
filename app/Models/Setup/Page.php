<?php

namespace App\Models\Setup;

use App\Http\Resources\Setup\Page as PageResource;
use App\Manager\RedisManager\RedisManager;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Page extends Base
{
    protected $table = 'pages';
    function __construct()
    {
        parent::__construct($this);
    }

    function getAllPagesForParent() {
        return Page::orderBy('id')->get();
    } 

    public function groups() //
    {
//        return $this->belongsToMany(Group::class); 'App\Models\Setup\Group'
        return $this->belongsToMany(Group::class, 'group_permissions', 'page_id', 'group_id');
    }

    function storeResource($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Page();
        $resource->name = $request->name;
        $resource->link = $request->link;
        $resource->translate = $request->translate;
        $resource->parent_id = $request->parent_id;
        $resource->type = $request->type;
        $resource->icon = $request->icon;
        $resource->badge = $request->badge;
        $resource->created_by = Auth::user()->staff_id;
        $resource->updated_by = Auth::user()->staff_id;
        $resource->save();

        if($resource->link) app('App\Models\Setup\GroupPermission')->storeResource('page', $resource->id);

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return PageResource
     */
    function updateResource($request, $id)
    {
        $resource = Page::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->link = $request->link;
        $resource->translate = $request->translate;
        $resource->parent_id = $request->parent_id;
        $resource->type = $request->type;
        $resource->icon = $request->icon;
        $resource->badge = $request->badge;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;
        $resource->save();

        return $resource;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    function deleteResource($id)
    {
        $resource = Page::find($id);
        if (empty($resource)) return response()->json(['message' => 'Resource not found.'], 404);

        if($resource->link) $resource->groups()->detach();

        $resource->delete();

        return $resource;
    }
}
