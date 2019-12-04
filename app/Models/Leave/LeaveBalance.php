<?php

namespace App\Models\Leave;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveBalance extends BaseModel
{
    protected $table = "leave_balance";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct($this);
    }

    public function allocated_leave_types()
    {
        return $this->belongsToMany(AllocatedLeaveTypes::class, 'leave_balance_type');
    }

    /**
     * Serializer field set for api purpose.
     */
    public function SerializerFields()
    {
        return ['id', 'name', 'user_id', 'allocated_leave_types'];
    }

    static public function PostSerializerFields()
    {
        return [
            'name', 'employee_id'
        ];
    }

    static public function FieldsValidator()
    {
        return [
            'name' => 'required',
            'employee_id' => 'required',
        ];
    }

    static public function leave_type_to_leave_allocated($user_id, $leave_type)
    {
        $annual_leave = $leave_type->maximumdays ? $leave_type->maximumdays : 0;
        $total_month = 12;
        $current_month = (int)Carbon::now()->isoFormat('M');
        $current_day = (int)Carbon::now()->isoFormat('D');
        $per_month_leave = ($annual_leave / $total_month);
        $annual_leave = round((($total_month - $current_month) * $per_month_leave) + ($current_day <= 15 ?
                $per_month_leave : $per_month_leave / 2));

        $allocated_leave_type = new AllocatedLeaveTypes();
        $allocated_leave_type->name = $leave_type->name;
        $allocated_leave_type->leave_type_id = $leave_type->id;
        $allocated_leave_type->user_id = $user_id;
        $allocated_leave_type->maximumdays = $annual_leave;
        $allocated_leave_type->includedWithAnnualLeave = $leave_type->includedWithAnnualLeave;
        $allocated_leave_type->save();
        return $allocated_leave_type->id;
    }

    static public function bridgeLeaveCounterInitialize($staff_id){
        $bridgeLeaveData = [ 'staff_id' => $staff_id, 'count' => 0 ];
        app('App\Models\Leave\BridgeLeaveCount')->store($bridgeLeaveData);
    }

    static public function EmployeeLeaveBalanceInitialize($user_id, $user_name)
    {
        LeaveBalance::bridgeLeaveCounterInitialize($user_id);
        $now = Carbon::now();
        $last_month = 12;
        $last_day = 31;
        $now->month = $last_month;
        $now->day = $last_day;

        $leave_types = LeaveType::all();
        $leave_type_ids = array();
        // user gender filter
        $genders_of_user = DB::table('employee_basic_info')->select('genders.name')->
        join('genders', 'employee_basic_info.genderId', '=', 'genders.id')->
        where('employee_basic_info.staff_id', '=', $user_id)->first();
        foreach ($leave_types as $type) {
            if(isset($genders_of_user->name) &&  (strtolower($genders_of_user->name) == 'male' || strtolower($genders_of_user->name) == 'm') ) {
                $MaternityLeave = 'maternity leave';
                if(isset($type->name) && strtolower($type->name) == $MaternityLeave) {
                    continue;
                }
            } else if(isset($genders_of_user->name) &&  (strtolower($genders_of_user->name) == 'female' || strtolower($genders_of_user->name) == 'f') ) {
                $PaternityLeave = 'paternity leave';
                if(isset($type->name) && strtolower($type->name) == $PaternityLeave) {
                    continue;
                }
            }
            $type_id = LeaveBalance::leave_type_to_leave_allocated($user_id, $type);
            $leave_type_ids[] = $type_id;
        }

        $leave_balance = new LeaveBalance();
        $leave_balance->user_id = $user_id;
        $leave_balance->name = $user_name;
        $leave_balance->start_time = Carbon::now()->timestamp;
        $leave_balance->end_time = $now->timestamp;
        $leave_balance->save();
        $leave_balance->allocated_leave_types()->attach($leave_type_ids);
        return $leave_balance;
    }
}
