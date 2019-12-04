<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Employee\Requisition;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class RequisitionRepository
{
    private $requisition;

    public function __construct(Requisition $requisition)
    {
        $this->requisition = $requisition;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->requisition->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->requisition->storeResource($data);
    }

    // update record in the database
    public function update(Request $data, $id)
    {

        return $this->requisition->updateResource($data, $id);
    }

    public function show( $id)
    {
        return $this->requisition->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->requisition->deleteResource($id);
    }
    public function employeeRequisition($id)
    {
        return $this->requisition->employeeRequisition($id);
    }
    public function employeeRequisitionRequest(Request $data, $id)
    {
        return $this->requisition->employeeRequisitionRequest($data, $id);
    }
    public function getEmployeeRequisitionRequestData($id)
    {
        return $this->requisition->getEmployeeRequisitionRequestData($id);
    }
}
