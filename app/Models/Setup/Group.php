<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * @method static find($group_id)
 */
class Group extends Base
{
    function __construct()
    {
        parent::__construct($this);
    }


    public function pages()
    {
//        'App\Models\Setup\Page'
        return $this->belongsToMany(Page::class, 'group_permissions', 'group_id', 'page_id');
    }


    /**
     * @param $request
     * @return Group|JsonResponse
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Group();

        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }

    /**
     * @param $request, $id
     * @return JsonResponse
     */
    function updateResource($request, $id) {
        $resource = Group::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
}
