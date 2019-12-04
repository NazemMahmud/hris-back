<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Repositories\Employee\RequestedDataRepository;
class RequestedDataController extends Controller
{
    private $requestedDataRepository;

    public function __construct(RequestedDataRepository $requestedDataRepository)
    {
        $this->requestedDataRepository = $requestedDataRepository;
    }
    public function basicInfoPendingUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->basicInfoPendingUpdateRequest($line_manager_id));
    }
    public function contactInfoPendingUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->contactInfoPendingUpdateRequest($line_manager_id));
    }
    public function familyInfoPendingUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->familyInfoPendingUpdateRequest($line_manager_id));
    }
    public function educationInfoPendingUpdateRequest($line_manager_id)
    {
        //return new EmployeeCollection($this->requestedDataRepository->educationInfoUpdateRequest($line_manager_id));
    }
    public function employeeInfoPendingUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->employeeInfoPendingUpdateRequest($line_manager_id));
    }


    public function basicInfoHistoryUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->basicInfoHistoryUpdateRequest($line_manager_id));
    }
    public function contactInfoHistoryUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->contactInfoHistoryUpdateRequest($line_manager_id));
    }
    public function familyInfoHistoryUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->familyInfoHistoryUpdateRequest($line_manager_id));
    }
    public function employeeInfoHistoryUpdateRequest($line_manager_id)
    {
        return new EmployeeCollection($this->requestedDataRepository->employeeInfoHistoryUpdateRequest($line_manager_id));
    }




    public function basicInfoUpdateRequest(Request $request, $staff_id)
    {
        return $this->requestedDataRepository->basicInfoUpdateRequest($request,$staff_id);
    }
    public function contactInfoUpdateRequest(Request $request, $staff_id)
    {
       return $this->requestedDataRepository->contactInfoUpdateRequest($request,$staff_id);
    }
    public function familyInfoUpdateRequest(Request $request, $staff_id)
    {
       return $this->requestedDataRepository->familyInfoUpdateRequest($request,$staff_id);
    }
    public function employeeInfoUpdateRequest(Request $request, $staff_id)
    {
       return $this->requestedDataRepository->employeeInfoUpdateRequest($request,$staff_id);
    }


}
