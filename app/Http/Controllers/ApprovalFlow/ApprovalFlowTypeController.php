<?php

namespace App\Http\Controllers\ApprovalFlow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovalFlow\ApprovalFlowTypeCollection;
use App\Http\Resources\ApprovalFlow\ApprovalFlowType as ApprovalFlowTypeResource;
use App\Models\ApprovalFlow\ApprovalFlowType;
use Illuminate\Http\JsonResponse;

class ApprovalFlowTypeController extends Controller
{
   
    /**
     * @var ApprovalFlowType
     */
    private $approvalFlowType;

    public function __construct(ApprovalFlowType $approvalFlowType)
    {
        $this->approvalFlowType = $approvalFlowType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ApprovalFlowTypeCollection
     */
    public function index()
    {
        return $this->approvalFlowType->getAll();
//        return new ApprovalFlowTypeCollection($this->approvalFlowType->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ApprovalFlowTypeResource
     */
    public function store(Request $request)
    {
        $result = $this->approvalFlowType->storeResource($request);
        return $result;
//        return (is_object(json_decode($result))) === false ?  $result :  new ApprovalFlowTypeResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ApprovalFlowTypeResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->approvalFlowType->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ApprovalFlowTypeResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return ApprovalFlowTypeResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->approvalFlowType->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new ApprovalFlowTypeResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ApprovalFlowTypeResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->approvalFlowType->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ApprovalFlowTypeResource($result);
    }
}
