<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\EmployeeChilden;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class EmployeeChildrenRepository
{
    private $employeeChilden;

    public function __construct(EmployeeChilden $employeeChilden)
    {
        $this->employeeChilden = $employeeChilden;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->employeeChilden->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->employeeChilden->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->employeeChilden->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->employeeChilden->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->employeeChilden->deleteResource($id);
    }
}
