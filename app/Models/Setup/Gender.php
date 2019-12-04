<?php

namespace App\Models\Setup;

use App\Http\Resources\Setup\GenderCollection;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Setup\Gender as GenderResource;
use Illuminate\Http\JsonResponse;
use App\Models\Base;
use App\Events\GenericRedisEvent;
use Illuminate\Support\Facades\Auth;

/**
 * @method static find($id)
 * @method static paginate(int $dataPerPage)
 */
class Gender extends Base
{
    /**
     * @var CacheTable
     */
    protected $CacheTable = true;

   /**
    * @var Gender
    */
    function __construct()
    {
        parent::__construct($this);
    }

    /**
     * @param int $dataPerPage
     * @return GenderCollection
     */
   /* function getAll($dataPerPage = 0) {
        return new GenderCollection(Gender::paginate($dataPerPage));
    }*/

    /**
     * @param $id
     * @return GenderResource
     */
  /*  function getById($id) {
        $gender = Gender::find($id);

        if (empty($gender)) return response()->json(['message' => 'Resource not found'], 404);

        return new GenderResource($gender);
    } */

    /**
     * @param $request
     * @return GenderResource|JsonResponse
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
           'name' =>  'required',
            'code' => 'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $gender = new Gender();

        $gender->name = $request->name;
        $gender->isActive = $request->isActive;
        $gender->isDefault = $request->isDefault;
        $gender->code = $request->code;
        $gender->created_by = Auth::user()->staff_id;
        $gender->updated_by = Auth::user()->staff_id;

        $gender->save();

        event(new GenericRedisEvent($gender));

        return new GenderResource($gender);
    }

    /**
     * @param $request
     * @param $id
     * @return GenderResource
     */
    function updateResource($request, $id) {
        $resource = Gender::find($id);

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

        return new GenderResource($resource);
    }
}
