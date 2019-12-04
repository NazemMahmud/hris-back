<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Employee\RequisitionRepository;
use App\Http\Resources\Employee\RequisitionCollection;
use App\Http\Resources\Employee\Requisition;

class RequisitionController extends Controller
{

    private $requisitionRepository;

    public function __construct(RequisitionRepository $requisitionRepository)
    {
        $this->requisitionRepository = $requisitionRepository;
    }

    public function index(Request $request)
    {
        return new RequisitionCollection($this->requisitionRepository->all($request));
    }

    public function store(Request $request)
    {
        $result = $this->requisitionRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new Requisition($result);
    }

    public function show($id)
    {
        $result = $this->requisitionRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new Requisition($result);
    }

    public function update(Request $request, $id)
    {
        return $result = $this->requisitionRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new Requisition($result);
    }

    public function destroy($id)
    {
        $result = $this->requisitionRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new Requisition($result);
    }
    public function employeeRequisition($employeeId){
         return $result = $this->requisitionRepository->employeeRequisition($employeeId);
    }
    public function employeeRequisitionRequest(Request $request, $id){
        return $result = $this->requisitionRepository->employeeRequisitionRequest($request, $id);
    }
    public function getEmployeeRequisitionRequestData($employeeId){
        return $result = $this->requisitionRepository->getEmployeeRequisitionRequestData($employeeId);
    }
}
