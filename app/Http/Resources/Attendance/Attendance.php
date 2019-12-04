<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Employee\Employee;
use App\Models\ShiftType\ShiftType;
use App\Models\Setup\AttendanceStatus;
class Attendance extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shift_name' =>$this->shift_name,
            'staff_id' => $this->staff_id,
            'name' => Employee::where('id',$this->staff_id)->first()?Employee::where('id',$this->staff_id)->first()->employeeName:'',
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
            'attendance_status' => AttendanceStatus::where('id',$this->attendance_status)->first()?  AttendanceStatus::where('id',$this->attendance_status)->first()->status:'',
            'overtime' => $this->overtime,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
