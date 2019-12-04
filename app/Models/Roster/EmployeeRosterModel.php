<?php

namespace App\Models\Roster;
use App\Models\Base\BaseModel;


class EmployeeRosterModel extends BaseModel
{
    protected $table = "employee_rosters";

    public function __construct()
    {
        parent::__construct($this);
    }

    /**
     * Get the roster that.
     */
    public function roster()
    {
        return $this->hasOne('App\Models\Roster\RosterModel', 'id', 'roster_id');
    }

    public function SerializerFields()
    {
        return ['id', 'roster', 'staff_id', 'start_dtime', 'end_dtime'];
    }

    static public function PostSerializerFields()
    {
        return ['roster_id', 'staff_id', 'start_dtime', 'end_dtime', 'created_by', 'updated_by', 'deleted_by'];
    }

    static public function FieldsValidator()
    {
        return [
            'roster_id' => 'required',
            'staff_id' => 'required', 
            'start_dtime' => 'required',
            'end_dtime' => 'required',
        ];
    }

    static public function latestEmployeeRoster($user_id) {
        $lastest_roster = EmployeeRosterModel::where('staff_id', '=', $user_id)
                            ->join('rosters', 'rosters.id', '=', 'employee_rosters.roster_id')
                            ->select('employee_rosters.id', 'rosters.start_time', 'rosters.end_time')
                            ->orderBy('employee_rosters.id', 'DESC')->get()->first();
        return $lastest_roster;
    }

    static public function last_roster($user_id) {
        $lastest_roster = EmployeeRosterModel::where('staff_id', '=', $user_id)
                            ->orderBy('id', 'DESC')->get()->first();
        return $lastest_roster;
    }
}
