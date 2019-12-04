<?php

namespace App\Http\Controllers\Employee;

use App\Http\Resources\Base\BaseResource;
use App\Http\Resources\SpecialChildrenBenefit\EmployeeInfoSpecialChildren as EmployeeInfoSpecialChildrenesource;
use App\Manager\RedisManager\RedisManager;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeeInfo as EmployeeInfoResource;
use App\Models\Employee\EmployeeInfo;
use App\Http\Resources\Setup\EmployeeInfoCollection;
use App\Http\Resources\Setup\EmployeeInfo as EmployeeInfoResources;
use App\Http\Resources\Setup\GroupEmployee;
use App\Http\Resources\Employee\LineManagerUnderHrbpResources;
use App\Http\Resources\Setup\EmployeeDepartmentCollection;
use App\Http\Resources\Setup\EmployeeDivisionCollection;
use App\Models\Employee\EmployeeChildrenInfo;
use App\Models\Employee\EmployeeDeceasedInfo;
use App\Models\Employee\EmployeeFamilyMemberInfo;
use App\Models\Setup\AttendenceTest;


class EmployeeInfoController extends Controller
{
    private $employeeDeceasedInfo;
    private $employeeInfo;
    private $employeeChildrenInfo;
    private $employeeFamilyMemberInfo;

    function __construct(EmployeeInfo $employeeInfo, EmployeeDeceasedInfo $employeeDeceasedInfo, EmployeeChildrenInfo $employeeChildrenInfo,
    EmployeeFamilyMemberInfo $employeeFamilyMemberInfo)

    {
        $this->employeeInfo = $employeeInfo;
        $this->employeeDeceasedInfo = $employeeDeceasedInfo;
        $this->employeeChildrenInfo = $employeeChildrenInfo;
        $this->employeeFamilyMemberInfo = $employeeFamilyMemberInfo;
    }

    public function getAge(Request $request){
        return ['age' => $this->employeeDeceasedInfo->getAge($request['dateOfBirth'])];
    }

    public function deceasedClaimStore(Request $request)
    {
        return ['data' => $this->employeeDeceasedInfo->storeResource($request['staff_id'], $request['updated_at'])];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            return $this->filter($request);
        }
       // return new EmployeeInfoCollection($this->employeeInfo->getAll($request->query('pageSize')));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->employeeInfo->storeResource($request);
//        return (is_object(json_decode($result))) === false ? $result : new EmployeeInfoResource($result);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return EmployeeInfoResources
     */
    public function show($id)
    {
        $result = $this->employeeInfo->getEmployeeInfoById($id);
        return (is_object($result)) ?  $result :  new EmployeeInfoResources($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->employeeInfo->updateResource($request, $id);
        return (is_object($result)) ?  $result :  new EmployeeInfoResources($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter($request)
    {
        $first_line_managers = EmployeeInfo::where('lineManager_1st', $request->staff_id)->get();
        if (!empty(sizeof($first_line_managers))) {
            return new BaseResource($first_line_managers);
        }
        return response()->json(['message' => 'Resource not found'], 404);
    }

    public function getEmployeeOrganogram(Request $request, $employee_id)
    {
        $organogramCache = RedisManager::Generic();
        $key = 'organogram_'.$employee_id;

        if($employee_id && $organogramCache->exists($key)) {
            return new BaseResource($organogramCache->get($key));
        } else {
            $employee_info = new EmployeeInfo();
            $currentEmployee = $employee_info->getCurrentEmployee($employee_id);
            if (!empty($currentEmployee)) {
                $employees = $employee_info->getRelatedEmployee($employee_id); //employee_id == first line manager
                $organogram = $employee_info->getOrganogram($employees);
                $data = [];
                $data['name'] = $currentEmployee->employeeName;
                $data['avatar'] = 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200';
                $data['children'] = $organogram;
                $employee_organogram = [];
                $employee_organogram[] = $data;
                $organogramCache->store($key, $employee_organogram);
                return new BaseResource($employee_organogram);;
            } else {
                return response()->json(['message' => 'Resource not found'], 404);
            }
        }
    }

    public function getGroupWiseEmployeeInfo(){

        $result = $this->employeeInfo->getGroupWiseEmployeeInfo();
        //return $result;
        return (is_object(json_decode($result))) === false ?  $result :  new GroupEmployee($result);
    }
    public function getEmployeeInfo($id){
        return $this->employeeInfo->getEmployeeAllInfoById($id);
    }
    public function getemployeedesignation($employeeId){
        return $this->employeeInfo->getemployeedesignation($employeeId);
    }
    public function getlinemanagerunderhrbp($employeeId){
        return new LineManagerUnderHrbpResources($this->employeeInfo->getlinemanagerunderhrbp($employeeId));
    }
    public function getDivisionRequitment($employeeId){
        return $this->employeeInfo->getDivisionRequitment($employeeId);
    }
    public function getDepartmentRequitment($employeeId){
        return $this->employeeInfo->getDepartmentRequitment($employeeId);
    }
    public function getUnitRequitment($employeeId){
        return $this->employeeInfo->getUnitRequitment($employeeId);
    }

    public function employeeChildInfo($staffId)
    {

        $result = $this->employeeChildrenInfo->EmployeeWiseChildren($staffId);
        return $result;
    }

    public function employeeFamilyInfo($staffId)
    {
        $result = $this->employeeFamilyMemberInfo->getEmployeeInfoById($staffId);
        return $result;
    }

    public function getByDepartment(Request $request){
        $employees = $this->employeeInfo->getByColumnName($request->departmentId, 'org_department_id');

        return (new Employee)->getEmployeeName($employees);
    }
    public function getEmployeeForSpecialChild(){
        return new EmployeeInfoSpecialChildrenesource($this->employeeInfo->getEmployeeForSpecialChild());
    }

}
