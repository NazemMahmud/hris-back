<?php

namespace App\Http\Controllers\Setup;

use App\Models\Leave\AllocatedLeaveTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\LeaveTypeCollection;
use App\Http\Resources\Setup\LeaveType as LeaveTypeResource;
use App\Models\Setup\LeaveType;
use Illuminate\Http\JsonResponse;

class LeaveTypeController extends Controller
{
    /**
     * @var LeaveType
     */
    private $leaveType;

    public function __construct(LeaveType $leaveType)
    {
        $this->leaveType = $leaveType;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LeaveTypeCollection
     */
    public function index(Request $request)
    {
        $orderBy = 'DESC';
         if($request->orderBy) {
             $orderBy = $request->orderBy;
         }
         if($request->searchBy)
        {
            return $this->searchResult($request->searchBy);
        }
        return new LeaveTypeCollection($this->leaveType->getAll($request->pageSize, $orderBy));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return LeaveTypeResource
     */
    public function store(Request $request)
    {
        $result = $this->leaveType->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveTypeResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return LeaveTypeResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->leaveType->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveTypeResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return LeaveTypeResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->leaveType->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveTypeResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return LeaveTypeResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->leaveType->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new LeaveTypeResource($result);
    }

    public function searchResult($searchBy)
    {
        return new leaveTypeCollection( $this->leaveType->searchResource($searchBy));
    }

    public function getEmployeeLeaveTypes(Request $request)
    {
        $types = AllocatedLeaveTypes::select('leave_type_id')->where('user_id', $request->employeeId)->get();
        $data = array();
        foreach($types as $leaveType)
        {
            $leaveTypeName = $this->leaveType->getResourceById($leaveType->leave_type_id);
            $data[] = array(
                'id' => $leaveTypeName->id,
                'name' => $leaveTypeName->name
            );
        }

        $leaveTypes = array( 'data' => $data );
        return $leaveTypes;
    }
}
