<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeeContactInfoCollection;
use App\Http\Resources\Employee\EmployeeContactInfo as EmployeeContactInfoResource;
use App\Models\Employee\EmployeeContactInfo;
use App\Repositories\Employee\EmployeeContactInfoRepository;
use App\Http\Resources\Employee\EmployeeContactInfoStore;
use Illuminate\Http\JsonResponse;


class EmployeeContactInfoController extends Controller
{

    private $employeeContactInfoRepository;

    public function __construct(EmployeeContactInfoRepository $employeeContactInfoRepository)
    {
        $this->employeeContactInfoRepository = $employeeContactInfoRepository;
    }

    public function index(Request $request)
    {
       // return new EmployeeContactInfoCollection($this->employeeContactInfoRepository->all($request));
    }

    public function store(Request $request)
    {
        $result =  $this->employeeContactInfoRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContactInfoStore($result);

    }

    public function show($id)
    {
        $result = $this->employeeContactInfoRepository->show($id);
        return (is_object($result)) ?  $result :  new EmployeeContactInfoResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->employeeContactInfoRepository->update($request, $id);
        return (is_object($result)) ?  $result :  new EmployeeContactInfoResource($result);
    }

    public function destroy($id)
    {
        $result = $this->employeeContactInfoRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeContactInfoStore($result);
    }

    // public function getNotUserEmployee(Request $request) {
    //      return $this->employeeContactInfo->NotUserEmployee();
    // }
}
