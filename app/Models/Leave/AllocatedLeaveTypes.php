<?php

namespace App\Models\Leave;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;

class AllocatedLeaveTypes extends BaseModel
{
    protected $table = "allocated_leave_types";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct($this);
    }

    public function leave_balance()
    {
        return $this->belongsToMany(LeaveBalance::class, 'leave_balance_type');
    }

    public function getLeaveBalance($staffId)
    {
        $leaveBalances = AllocatedLeaveTypes::where('user_id', $staffId)->get();
        $leaveBalance = [];
        foreach ($leaveBalances as $balance){
            $leaveBalance[] = [
                'name' => $balance->name,
                'entitled' => $balance->maximumdays,
                'taken' => $balance->allocated_day,
                'carryForward' => $balance->carryForwardDayAnnually,
                'balance' => ($balance->maximumdays - $balance->allocated_day),
                'isActive' => $balance->isActive,
                'isDefault' => $balance->isDefault
            ];
        }

//        $table->unsignedBigInteger('includedWithAnnualLeave');

        return $leaveBalance;
    }

    function updateLeaveBalance($leaveRequest){
        $leaveBalanceUpdate = AllocatedLeaveTypes::where('user_id', $leaveRequest->staff_id)
            ->where('leave_type_id', $leaveRequest->leave_type_id)->first();
        $leaveBalanceUpdate->maximumdays = $leaveBalanceUpdate->maximumdays - $leaveRequest->totalDurationDays;
        $leaveBalanceUpdate->allocated_day = $leaveBalanceUpdate->allocated_day + $leaveRequest->totalDurationDays;
        $leaveBalanceUpdate->save();
    }
}
