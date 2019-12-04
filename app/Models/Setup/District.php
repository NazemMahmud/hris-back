<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Events\GenericRedisEvent;


class District extends Base
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
     * @return District
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'division_id' => 'required',
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new District();

        $resource->division_id = $request->division_id;
        $resource->name = $request->name;
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
        $resource = District::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'division_id' => 'required',
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->division_id = $request->division_id;
        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }

    function searchDivisionId($divisionId)
     {
        $resource = $this->model::where('division_id', 'like', "%{$divisionId}%")->get();
        if (empty($resource)) return response()->json(['message' => 'Resource not found.']);
        return $resource ;
     }   
}