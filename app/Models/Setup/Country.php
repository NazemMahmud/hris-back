<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Events\GenericRedisEvent;


class Country extends Base
{

     /**
     * @var CacheTable
     */
    protected $CacheTable = true;

    public $resource;

    public function __construct()
    {
        parent::__construct($this);
    }

    /**
     * @param $request
     * @return Country
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'code' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Country();

        $resource->name = $request->name;
        $resource->code = $request->code;
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
        $resource = Country::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'code' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->name = $request->name;
        $resource->code = $request->code;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }
}
