<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Events\GenericRedisEvent;


class Branch extends Base
{

    /**
     * @var CacheTable 
    */
    protected $CacheTable = true;

    public function __construct()
    {
        parent::__construct($this);
    }

    /**
     * @param $request
     * @return Branch
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'address' => 'required',
            'isHeadOffice'=> 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Branch();

        $resource->name = $request->name;
        $resource->address = $request->address;
        $resource->isHeadOffice = $request->isHeadOffice;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id) {
        $resource = Branch::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'address' => 'required',
            'isHeadOffice'=> 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->address = $request->address;
        $resource->isHeadOffice = $request->isHeadOffice;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }
}
