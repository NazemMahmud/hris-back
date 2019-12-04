<?php

namespace App\Models\Employee;

use App\Manager\RedisManager\RedisManager;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ShiftType\ShiftType;
use App\Models\Base;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\Employee;
use App\Models\Setup\Division;
use App\Models\Setup\EmployeeUnit;
use App\Models\Setup\EmployeeDepartment;
use App\Models\Employee\EmployeeDeceasedInfo;
use App\User;
use App\Models\Employee\EmployeeInfoUpdateRequest;

class EmployeeInfo extends Base
{
    protected $table = "employee_info";
    protected $unique_staff = array();

    public function __construct()
    {
        parent::__construct($this);
    }

    function employee(){
        return $this->belongsTo('App\Models\Employee\Employee', 'staff_id', 'id');
    }

    function division(){
        return $this->belongsTo('App\Models\Setup\EmployeeDivision', 'org_division_id','id');
    }
    function department(){
        return $this->belongsTo('App\Models\Setup\EmployeeDepartment', 'org_department_id','id');
    }
    function band(){
        return $this->belongsTo('App\Models\Setup\Band', 'band_id','id');
    }


    function storeResource($request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'employee_type' => 'required',
            'org_division_id' => 'required',
            'org_department_id' => 'required',
            'org_unit_id' => 'required',
            'location_id' => 'required',
            'subLocation_id' => 'required',
            'jobLevel_id' => 'required',
            'lineManager_1st' => 'required',
            'lineManager_2nd' => 'required',
            'hrbp' => 'required',
            'shiftType_id' => 'required',
            'joiningDate' => 'required',
            'position_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);
        $resource = EmployeeInfo::where('staff_id', '=', $request->staff_id)->first();
        if (empty($resource)) {
            $resource = new EmployeeInfo();
        }

        $resource->staff_id = $request->staff_id;
        $resource->employee_type = $request->employee_type;
        $resource->org_division_id = $request->org_division_id;
        $resource->org_department_id = $request->org_department_id;
        $resource->location_id = $request->location_id;
        $resource->subLocation_id = $request->subLocation_id;
        $resource->jobLevel_id = $request->jobLevel_id;
        $resource->lineManager_1st = $request->lineManager_1st;
        $resource->lineManager_2nd = $request->lineManager_2nd;
        $resource->hrbp = $request->hrbp;
        $resource->shiftType_id = $request->shiftType_id;
        $resource->position_id = $request->position_id;
        $resource->joiningDate = Helper::formatdate($request->joiningDate);

        if ($request->has('employment_date')) {
            $resource->employment_date = Helper::formatdate($request->employment_date);
        }

        if ($request->has('employment_end_date')) {
            $resource->employment_end_date = Helper::formatdate($request->employment_end_date);
        }

        if ($request->has('contract_end_date')) {
            $resource->contract_end_date = Helper::formatdate($request->contract_end_date);
        }
        if ($request->has('exit_date')) {
            $resource->exit_date = Helper::formatdate($request->exit_date);
        }

        if ($request->has('employee_org_id')) {
            $resource->employee_org_id = $request->employee_org_id;
        }
        if ($request->has('probation_end_date')) {
            $resource->probation_end_date = Helper::formatdate($request->probation_end_date);
        }

        $resource->save();
        if ($resource->employee_status_id == 2) {
            app('App\Models\Employee\EmployeeDeceasedInfo')->storeResource($request->staff_id, $resource->updated_at);
        }
        $key = 'organogram_' . $resource->lineManager_1st;
        $employeeCache = RedisManager::Generic();
        if ($resource->lineManager_1st && $employeeCache->exists($key)) {
            $employeeCache->delete($key);
        }
        return $resource;
    }

    function updateResource($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'employee_type' => 'required',
            'org_division_id' => 'required',
            'org_department_id' => 'required',
            'org_unit_id' => 'required',
            'location_id' => 'required',
            'subLocation_id' => 'required',
            'jobLevel_id' => 'required',
            'lineManager_1st' => 'required',
            'lineManager_2nd' => 'required',
            'hrbp' => 'required',
            'shiftType_id' => 'required',
            'joiningDate' => 'required',
            'position_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $data['info'] = EmployeeInfo::where('staff_id', '=', $id)->first();

        if (empty($data['info'])) return response()->json(['message' => 'Resource not found'], 404);

        $resource = EmployeeInfoUpdateRequest::where('staff_id', '=', $request->staff_id)->first();

        if (empty($resource)) {
            $resource = new EmployeeInfoUpdateRequest();
        }
        $resource->employee_info_id = $data['info']->id;
        $resource->staff_id = $request->staff_id;
        $resource->employee_type = $request->employee_type;
        $resource->org_division_id = $request->org_division_id;
        $resource->org_department_id = $request->org_department_id;
        $resource->location_id = $request->location_id;
        $resource->subLocation_id = $request->subLocation_id;
        $resource->jobLevel_id = $request->jobLevel_id;
        $resource->lineManager_1st = $request->lineManager_1st;
        $resource->lineManager_2nd = $request->lineManager_2nd;
        $resource->hrbp = $request->hrbp;
        $resource->shiftType_id = $request->shiftType_id;
        $resource->position_id = $request->position_id;
        $resource->joiningDate = Helper::formatdate($request->joiningDate);

        if ($request->has('employment_date')) {
            $resource->employment_date = Helper::formatdate($request->employment_date);
        }

        if ($request->has('employment_end_date')) {
            $resource->employment_end_date = Helper::formatdate($request->employment_end_date);
        }

        if ($request->has('contract_end_date')) {
            $resource->contract_end_date = Helper::formatdate($request->contract_end_date);
        }
        if ($request->has('exit_date')) {
            $resource->exit_date = Helper::formatdate($request->exit_date);
        }

        if ($request->has('employee_org_id')) {
            $resource->employee_org_id = $request->employee_org_id;
        }
        if ($request->has('probation_end_date')) {
            $resource->probation_end_date = Helper::formatdate($request->probation_end_date);
        }

        if ($request->has('bank_id')) {
            $resource->bank_id = $request->bank_id;
        }
        if ($request->has('bank_account_no')) {
            $resource->bank_account_no = $request->bank_account_no;
        }
        if ($request->has('bank_account_name')) {
            $resource->bank_account_name = $request->bank_account_name;
        }
        if ($request->has('tax_responsible_id')) {
            $resource->tax_responsible_id = $request->tax_responsible_id;
        }
        if ($request->has('payment_type_id')) {
            $resource->payment_type_id = $request->payment_type_id;
        }
        if ($request->has('working_day_id')) {
            $resource->working_day_id = $request->working_day_id;
        }
        if ($request->has('employee_status_id')) {
            $resource->employee_status_id = $request->employee_status_id;
        }
        if ($request->has('exit_reason_id')) {
            $resource->exit_reason_id = $request->exit_reason_id;
        }

        $resource->status = 0;

        $resource->save();
        $data['request'] = $resource;

        return $data;
    }

    public function getEmployeeShiftinfo($employeeId)
    {
        $employeeinfo = $this::where('staff_id', $employeeId)->first();
        if (!empty($employeeinfo)) {
            return ShiftType::select('startTime', 'endTime')->where('id', $employeeinfo->shiftType_id)->first();
        }
        return json_encode('Not found');
    }

    public function shiftType()
    {
        return $this->hasOne('App\Models\ShiftType\ShiftType', 'id', 'shiftType_id');
    }

    public function getCurrentEmployee($employee_id)
    {
        $employees = EmployeeInfo::where('staff_id', '=', $employee_id)->
        join('employees', 'employee_info.staff_id', '=', 'employees.id')->
        leftjoin('positions', 'employee_info.position_id', '=', 'positions.id')->
        select('employee_info.staff_id', 'employees.employeeName', 'positions.name AS label')->first();
        return $employees;
    }

    public function getRelatedEmployee($employee_id)
    {
        $employees = EmployeeInfo::where('lineManager_1st', '=', $employee_id)->
        join('employees', 'employee_info.staff_id', '=', 'employees.id')->
        leftjoin('positions', 'employee_info.position_id', '=', 'positions.id')->
        select('employee_info.staff_id', 'employees.employeeName', 'positions.name AS label')->get();
        return $employees;
    }

    public function getOrganogram($employees)
    {
        $organogram = array();
        foreach ($employees as $employee) {
            if ($employee['staff_id']) {
                if (in_array($employee['staff_id'], $this->unique_staff)) {
                    return $employee;
                } else {
                    $this->unique_staff[] = $employee['staff_id'];
                }
                $children_employees = $this->getRelatedEmployee($employee['staff_id']);
                if ($children_employees) {
                    $employee['name'] = $employee['employeeName'];
                    $employee['avatar'] = 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200';
                    $employee['children'] = $children_employees;
                }
                $organogram[] = $employee;
                $this->getOrganogram($children_employees);
            }
        }
        return $organogram;
    }

    public function getGroupWiseEmployeeInfo()
    {
        $resource = DB::table('users')
            ->join('employees', 'users.staff_id', '=', 'employees.id')
            ->select('users.staff_id', 'employees.employeeName as employee_name')
            ->where('users.group_id', '=', '2')
            ->get();
        if (count($resource) == 0) return response()->json(['message' => 'Resource not found.']);
        return $resource;
    }

    function getEmployeeInfoById($id)
    {
        $resource['info'] = EmployeeInfo::where('staff_id', '=', $id)->first();

        if (empty($resource['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        $resource['request'] = EmployeeInfoUpdateRequest::where('staff_id', $id)->first();

        return $resource;
    }

    function getEmployeeInfo($staff_id)
    {
        return EmployeeInfo::where('staff_id', '=', $staff_id)->first();
    }

    function getEmployeeAllInfoById($id)
    {
        $resource = EmployeeInfo::where('staff_id', '=', $id)->first();
        if (empty($resource)) {
            return response()->json(['errors' => 'id is not valid'], 404);
        }
        $Employee = Employee::find($id);
        if (!empty($resource->org_division_id)) {
            $Division = Division::find($resource->org_division_id);
        }
        if (!empty($resource->org_unit_id)) {
            $EmployeeUnit = EmployeeUnit::find($resource->org_unit_id);
        }
        if (!empty($resource->org_department_id)) {
            $EmployeeDepartment = EmployeeDepartment::find($resource->org_department_id);
        }
        $data['employee_name'] = $Employee ? $Employee->employeeName : '';
        $data['division_name'] = $Division ? $Division->name : '';
        $data['unit_name'] = $EmployeeUnit ? $EmployeeUnit->name : '';
        $data['department_name'] = $EmployeeDepartment ? $EmployeeDepartment->name : '';

        return $data;
    }

    function getemployeedesignation($id)
    {
        $resource = EmployeeInfo::where('hrbp', '=', $id)->first();
        if (!empty($resource)) {
            return response()->json(['data' => 'hrbp'], 200);
        }
        return response()->json(['data' => 'lineManager'], 200);
    }

    function getlinemanagerunderhrbp($employeeId)
    {
        $datas['data'] = EmployeeInfo::where('hrbp', $employeeId)->select('lineManager_1st')->get();
        foreach ($datas['data'] as $key => $data) {
            $employee = Employee::where('id', $data->lineManager_1st)->select('id', 'employeeName')->first();
            $data['employeeName'] = $employee->employeeName ? $employee->employeeName : '';
            $data['id'] = $employee->id ? $employee->id : '';
        }
        if (!empty($datas['data'])) {
            return $datas['data'];
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }

    function getDivisionRequitment($employeeId)
    {
        $hrbp = $this->checkIfHRBP($employeeId);
        if ($hrbp == true) {
            return Division::all();
        } else {
            $division = $this->EmployeeUnderDivision($employeeId);
            if ($division) {
                return Division::where('id', $division->org_division_id)->first();
            }
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }

    function getUnitRequitment($employeeId)
    {
        $hrbp = $this->checkIfHRBP($employeeId);
        if ($hrbp == true) {
            return EmployeeUnit::all();
        } else {
            $unit = $this->EmployeeUnderUnit($employeeId);
            if ($unit) {
                return EmployeeUnit::where('id', $unit->org_unit_id)->first();
            }
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }

    function getDepartmentRequitment($employeeId)
    {
        $hrbp = $this->checkIfHRBP($employeeId);
        if ($hrbp == true) {
            return EmployeeDepartment::all();
        } else {
            $department = $this->EmployeeUnderDepartment($employeeId);
            if ($department) {
                return Division::where('id', $department->org_department_id)->first();
            }
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }

    public function checkIfHRBP($employeeId)
    {
        $employeeInfo = EmployeeInfo::where('hrbp', $employeeId)->get();
        return count($employeeInfo) > 0 ? true : false;
    }

    public function EmployeeUnderDepartment($employeeId)
    {
        $employeeInfo = EmployeeInfo::where('staff_id', $employeeId)->select('org_department_id')->first();
        return $employeeInfo;
    }

    public function EmployeeUnderDivision($employeeId)
    {
        $employeeInfo = EmployeeInfo::where('staff_id', $employeeId)->select('org_division_id')->first();
        return $employeeInfo;
    }

    public function EmployeeUnderUnit($employeeId)
    {
        $employeeInfo = EmployeeInfo::where('staff_id', $employeeId)->select('org_unit_id')->first();
        return $employeeInfo;
    }

    function getEmployeeForSpecialChild(){
        return $this::where('staff_id', Auth::user()->staff_id)->first();
    }

}
