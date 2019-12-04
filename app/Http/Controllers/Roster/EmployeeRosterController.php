<?php

namespace App\Http\Controllers\Roster;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Base\BaseResource;
use App\Models\Roster\EmployeeRosterModel;

class EmployeeRosterController extends BaseController
{
    public function __construct(EmployeeRosterModel $employee_roster)
    {
        $this->EntityInstance = $employee_roster;
        parent::__construct();
    }

    public function getEmployeeRoster(Request $request) {
        $rosters = EmployeeRosterModel::join('rosters', 'rosters.id', '=', 'employee_rosters.roster_id')
                    ->join('employees', 'employees.id', '=', 'employee_rosters.staff_id')
                    ->select('employee_rosters.id', 'rosters.name', 'employees.employeeName', 'employee_rosters.start_dtime', 'employee_rosters.end_dtime')->get();
        if (!empty(sizeof($rosters))) {
            return new BaseCollection($rosters);
        }
        return response()->json(['message' => 'Resource not found'], 404);
    }
}
