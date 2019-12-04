<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Employee\EmployeeChildrenInfo;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class EmployeeChildrenRepository

{
    private $employeeChildrenInfo;

    public function __construct(EmployeeChildrenInfo $employeeChildrenInfo)
    {
        $this->employeeChildrenInfo = $employeeChildrenInfo;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->employeeChildrenInfo->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->employeeChildrenInfo->storeResource($data);
    }

    // update record in the database
    public function update(Request $data, $id)
    {

        return $this->employeeChildrenInfo->updateResource($data, $id);
    }

    public function show( $id)
    {
        return $this->employeeChildrenInfo->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->employeeChildrenInfo->deleteResource($id);
    }
    public function EmployeeWiseChildren($staffId)
    {
        return $resource = $this->employeeChildrenInfo->EmployeeWiseChildren($staffId);

    }

}
