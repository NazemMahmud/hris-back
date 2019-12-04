<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Employee\EmployeeFamilyMemberInfo;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class EmployeeFamilyMemberInfoRepository
{
    private $employeeFamilyMemberInfo;

    public function __construct(EmployeeFamilyMemberInfo $employeeFamilyMemberInfo)
    {
        $this->employeeFamilyMemberInfo = $employeeFamilyMemberInfo;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->employeeFamilyMemberInfo->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->employeeFamilyMemberInfo->storeResource($data);
    }

    // update record in the database
    public function update(Request $data, $id)
    {
        $record = $this->find($id);
        return $this->employeeFamilyMemberInfo->updateResource($data, $id);
    }

    public function show( $id)
    {
        return $this->employeeFamilyMemberInfo->getEmployeeInfoById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->employeeFamilyMemberInfo->deleteEmployeeInfoById($id);
    }
}
