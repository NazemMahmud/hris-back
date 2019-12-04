<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leave\LeaveApprovalRequestsCollection;
use App\Http\Resources\Leave\LeaveApprovalRequests as LeaveApprovalRequestsResource;
use App\Models\Leave\LeaveApprovalRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LeaveApprovalRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $leaveApprovalRequests;

    public function __construct(LeaveApprovalRequests $leaveApprovalRequests)
    {
        $this->leaveApprovalRequests = $leaveApprovalRequests;
    }
    public function index()
    {
        return new LeaveApprovalRequestsCollection($this->leaveApprovalRequests->getall());
    }

    public function store(Request $request)
    {
        $result = $this->leaveApprovalRequests->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveApprovalRequestsResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return LeaveApprovalRequestsResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->leaveApprovalRequests->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveApprovalRequestsResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return LeaveApprovalRequestsResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->leaveApprovalRequests->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveApprovalRequestsResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return LeaveApprovalRequestsResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->leaveApprovalRequests->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveApprovalRequestsResource($result);
    }

    public function approveLeaveRequest($id)
    {
        $this->leaveApprovalRequests->getResourceById($id);
    }
}
