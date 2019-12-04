<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Http\Resources\Employee\EmployeeContactInfo as EmployeeContactInfoResource;
use App\Http\Resources\Employee\BasicInfo as BasicInfoResource;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\EmployeeEducationInfo as EmployeeEducationInfoResource;
use App\Http\Resources\Employee\EmployeeFamilyMemberInfo as EmployeeFamilyMemberInfoResource;
use App\GenericSolution\GenericModels\Import\Employee\EmployeeImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee\EmployeeInfo;

class EmployeeController extends Controller
{
    private $employee;
    private $employeeInfo;
    function __construct(Employee $employee,EmployeeInfo $employeeInfo)
    {
        $this->employee = $employee;
        $this->employeeInfo = $employeeInfo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return new EmployeeCollection($this->employee->getAll($request->query('pageSize'),$orderBy));
    }
    public function getEmployeeBasicInfo($id){
        $result = $this->employee->employeeBasicInfo($id);
        return (is_object(json_decode($result))) === false ?  $result :  new BasicInfoResource($result);
    }
    public function getEmployeeEducationInfo($id){
        $result = $this->employee->employeeEducationInfo($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeEducationInfoResource($result);
    }
    public function getEmployeeContactInfo($id){
        $result = $this->employee->employeeContactInfo($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContactInfoResource($result);
    }

    public function show(){

    $result = $this->employeeInfo->getGroupWiseEmployeeInfo();
    return (is_object(json_decode($result))) === false ?  $result :  new GroupEmployee($result);

    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'=> 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        try {
            Excel::import(new EmployeeImport, request()->file('file'));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
        return response()->json(['success' => 'File import successfully'], 200);
    }
}
