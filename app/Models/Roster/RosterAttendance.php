<?php

namespace App\Models\Roster;
use App\Models\Base\BaseModel;
use Carbon\Carbon;

class RosterAttendance extends BaseModel
{
    protected $table = "roster_attendance";
    public function __construct()
    {
        parent::__construct($this);
    }

    public function SerializerFields()
    {
        return ['id', 'staff_id', 'eroster_id', 'checkin_time', 
            'Checkout_time', 'date', 'due_time', 'over_time'
        ];
    }

    static public function PostSerializerFields()
    {
        return ['staff_id', 'eroster_id', 'checkin_time', 
            'Checkout_time', 'date', 'due_time', 'over_time'
        ];
    }

    static public function FieldsValidator()
    {
        return [
            'staff_id' => 'required',
            'eroster_id' => 'required', 
            'checkin_time' => 'required',
            'Checkout_time' => 'required',
            'date' => 'required',
            'due_time' => 'required',
            'over_time' => 'required',
        ];
    }

    public static function lastPeriod()
    {
        $last_attendace = RosterAttendance::latest()->first();
        return !empty($last_attendace) ? $last_attendace->created_at : Carbon::createFromFormat('Y-m-d H', '1970-01-01 22')->toDateTimeString();;
    }

}
