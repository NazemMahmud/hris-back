<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Employee\EmployeeContactInfo;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class EmployeeContactInfoRepository
{
    private $employeeContactInfo;

    public function __construct(EmployeeContactInfo $employeeContactInfo)
    {
        $this->employeeContactInfo = $employeeContactInfo;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->employeeContactInfo->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->employeeContactInfo->storeResource($data);
    }

    // update record in the database
    public function update(Request $data, $id)
    {
        return $this->employeeContactInfo->updateResource($data, $id);
    }

    public function show( $id)
    {
        return $this->employeeContactInfo->getEmployeeInfoById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->employeeContactInfo->deleteEmployeeInfoById($id);
    }
}
