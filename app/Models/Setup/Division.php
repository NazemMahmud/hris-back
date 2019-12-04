<?php

namespace App\Models\Setup;

use App\Models\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Events\GenericRedisEvent;


class Division extends Base
{
    /**
     * @var CacheTable
    */
    protected $CacheTable = true;

    public function __construct()
    {
        parent::__construct($this);
    }
    public function district()
    {
        return $this->hasMany(District::class);
    }

    /**
     * @param $request
     * @return Division
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'country_id' =>  'required',
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new Division();

        $resource->country_id = $request->country_id;
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
        $resource = Division::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'country_id' =>  'required',
            'name' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->country_id = $request->country_id;
        $resource->name = $request->name;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }

    function searchCountryId($countryId)
     {
        $resource = $this->model::where('country_id', 'like', "%{$countryId}%")->get();
        if (empty($resource)) return response()->json(['message' => 'Resource not found.']);
        return $resource ;
     }  
}