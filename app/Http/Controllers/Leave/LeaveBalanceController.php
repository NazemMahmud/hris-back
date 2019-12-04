<?php

namespace App\Http\Controllers\Leave;

use App\Http\Resources\Base\BaseCollection;
use App\Models\Leave\AllocatedLeaveTypes;
use App\Models\Leave\LeaveBalance;
use App\Http\Resources\Base\BaseResource;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * @author Fazlul Kabir Shohag <shohag.fks@gmail.com>
 */
class LeaveBalanceController extends BaseController
{
    private $allocatedLeaveTypes;

    public function __construct(LeaveBalance $leaveBalance, AllocatedLeaveTypes $allocatedLeaveTypes)
    {
        $this->EntityInstance = $leaveBalance;
        $this->allocatedLeaveTypes = $allocatedLeaveTypes;
        parent::__construct();
    }

    public function index(Request $request)
    {
        if ($request->search) {
            return $this->filter($request);
        }
        return new BaseCollection($this->EntityInstance->getAll());
    }

    public function filter($request)
    {
        if ($request->leave_type_id) {
            $result = AllocatedLeaveTypes::where('user_id', '=', $request->user_id)->where('leave_type_id', '=', $request->leave_type_id)->get();
        } else {
            $result = AllocatedLeaveTypes::where('user_id', '=', $request->user_id)->get();

        }
        return (is_object(json_decode($result))) === false ? $result : new BaseResource($result);
    }

    public function getRemainingLeave(Request $request)
    {
        if ($request['employeeId']) {
            $getBalance = AllocatedLeaveTypes::select('maximumdays')->where('user_id', $request['employeeId'])
                ->where('leave_type_id', $request['leaveTypeid'])->first();

            return [
                'data' => $getBalance->maximumdays
            ];
        }
    }

    /**
     * @param $staffId
     * @return array
     */
    public function getLeaveBalance(Request $request)
    {
        if ($request['staffId']) {
            $leaveBalance = $this->allocatedLeaveTypes->getLeaveBalance($request['staffId']);
            return [
                'data' => $leaveBalance
            ];
        }
    }
}
