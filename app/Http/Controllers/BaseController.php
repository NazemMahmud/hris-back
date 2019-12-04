<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Base\BaseResource;
use App\Http\Resources\Base\BaseCollection;
use Illuminate\Http\JsonResponse;
/**
 * @author Fazlul Kabir Shohag <shohag.fks@gmail.com>
 */
class BaseController extends Controller
{

    public function __construct()
    {
        /**
         * Serializer field set for every model individually.
         */
        if(method_exists($this->EntityInstance, 'SerializerFields')){
            BaseResource::SerializerFieldsSet($this->EntityInstance->SerializerFields());
        }
    }

    /**
     * @var EntityModel
     */
    protected $EntityInstance;

    /**
     * Display a listing of the resource.
     *
     * @return BaseCollection
     */
    public function index(Request $request)
    {
        return new BaseCollection($this->EntityInstance->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BaseResource
     */
    public function store(Request $request)
    {
        $result = $this->EntityInstance->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new BaseResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BaseResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->EntityInstance->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BaseResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return BaseResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->EntityInstance->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new BaseResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return BaseResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->EntityInstance->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BaseResource($result);
    }
}
