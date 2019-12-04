<?php

namespace App\Http\Controllers\Employee;

use App\Http\Resources\Employee\EmployeeCollection;
use App\Models\Designation\DesignationModel;
use App\Models\Designation\EmployeeDesignation;
use App\Models\Employee\EmployeeInfo;
use App\Models\Setup\Division;
use App\Models\Setup\EmployeeDepartment;
use App\Models\Setup\EmployeeDivision;
use App\Models\Setup\EmployeeLevel;
use App\Models\Setup\EmployeeLocation;
use App\Models\Setup\EmployeeType;
use App\Models\Setup\Gender;
use App\Models\Setup\Position;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee\BasicInfo;
use App\Models\Employee\Employee;
use App\Http\Resources\Employee\BasicInfo as BasicInfoResource;
use App\Http\Resources\Employee\BasicInfoStore ;
use App\Http\Resources\Employee\BasicInfoCollection;
use Illuminate\Http\Response;

class BasicInfoController extends Controller
{
    /**
     * @var BasicInfo
     * @var Employee
     */
    private $basicInfo;
    private $employee;

    function __construct(BasicInfo $basicInfo, Employee $employee)
    {
        $this->basicInfo = $basicInfo;
        $this->employee = $employee;
    }

    /**
     * @param Request $request
     * @return BasicInfoCollection
     */
    public function index(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
       // return new BasicInfoCollection($this->employee->getAll($request->query('pageSize'),$orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $result = $this->basicInfo->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new BasicInfoStore($result);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $result = $this->basicInfo->getResourceById($id);
        return (is_object($result)) ?  $result :  new BasicInfoResource($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->basicInfo->updateResource($request, $id);
        return (is_object($result)) ?  $result :  new BasicInfoResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadImage(Request $request, $staffId)
    {
        $result = $this->basicInfo->uploadImage($request, $staffId);
        return $result;
    }

    /**
     * @return EmployeeCollection
     */

    public function getAllNames()
    {
        return new EmployeeCollection($this->employee->getAll());
    }

    public function employeeInfo(Request $request)
    {
        if ($request['id']) {
            $employee = Employee::where('id', $request['id'])->first();

            if ($employee) {
                $basicInfo = BasicInfo::where('staff_id', $request['id'])->first();
                $employeeInfo = EmployeeInfo::where('staff_id', $request['id'])->first();
                $employeeAsUser = User::where('staff_id', $request['id'])->first();
                $position = Position::select('name')->where('id', isset($employeeAsUser->position_id) ? $employeeAsUser->position_id: -1)->first();
                $gender = Gender::select('name')->where('id', isset($basicInfo->genderId) ? $basicInfo->genderId: -1)->first();

                if ($employeeInfo && !empty($employeeInfo)) {
                    $division = EmployeeDivision::select('name')->where('id', $employeeInfo->org_division_id)->first();
                    $depatment = EmployeeDepartment::select('name')->where('id', $employeeInfo->org_department_id)->first();
                    $jobLevel = EmployeeLevel::select('job_level')->where('id', $employeeInfo->jobLevel_id)->first();
                    $location = EmployeeLocation::select('name')->where('id', $employeeInfo->location_id)->first();
                    $firstLineManager = Employee::select('employeeName')->where('id', $employeeInfo->lineManager_1st)->first();
                    $secondLineManager = Employee::select('employeeName')->where('id', $employeeInfo->lineManager_2nd)->first();
                    $hrbp = Employee::select('employeeName')->where('id', $employeeInfo->hrbp)->first();
                    $designation = EmployeeDesignation::where('id', $employeeInfo->designation_id)->first();
                }

                $data = array(
                    'employeeName' => isset($employee, $employee->employeeName) ? $employee->employeeName: '',
                    'position' => isset($position, $position->name) ? $position->name: '',
                    'staffId' => $request['id'],
                    'gender' => isset($gender, $gender->name) ? $gender->name: '',
                    'organizationDivision' => isset($division, $division->name) ? $division->name: '',
                    'organizationDepartment' => isset($depatment, $depatment->name) ? $depatment->name: '',
                    'jobLevel' => isset($jobLevel, $jobLevel->job_level) ? $jobLevel->job_level: '',
                    'location' => isset($location, $location->name) ? $location->name: '',
                    'contractType' => '',
                    'joiningDate' => isset($employee, $employee->created_at) ? date('Y-m-d', strtotime($employee->created_at)): '',
                    'email' => isset($employeeAsUser, $employeeAsUser->email) ? $employeeAsUser->email: '',
                    'firstLineManager' => isset($firstLineManager, $firstLineManager->employeeName) ? $firstLineManager->employeeName: '',
                    'secondLineManager' => isset($secondLineManager, $secondLineManager->employeeName) ? $secondLineManager->employeeName: '',
                    'hrbp' => isset($secondLineManager, $hrbp->employeeName) ? $hrbp->employeeName: '',
                    'designation' => isset($designation, $designation->name) ? $designation->name: '',
                );
                $profile = array('data' => $data);
            } else {
                $data = array(
                    'errorMessage' => 'Employee is not present'
                );
                $profile = array('data' => $data);
            }

        } else {
            $data = array(
                'errorMessage' => 'Employee Id not present'
            );
            $profile = array('data' => $data);
        }
        return $profile;
    }
}
