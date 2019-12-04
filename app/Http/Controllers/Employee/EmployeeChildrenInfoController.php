<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Employee\EmployeeChildrenRepository;
use App\Http\Resources\Employee\EmployeeChildrenCollection;
use App\Http\Resources\Employee\EmployeeChildren as EmployeeChildrenInfoResource;
use App\Http\Resources\Employee\EmployeeWiseChildren;
use App\Http\Resources\Employee\EmployeeWiseChildrenCollection;

class EmployeeChildrenInfoController extends Controller
{
    private $employeeChildrenRepository;

    public function __construct(EmployeeChildrenRepository $employeeChildrenRepository)
    {
        $this->employeeChildrenRepository = $employeeChildrenRepository;
    }

    public function index(Request $request)
    {
        return new EmployeeChildrenCollection($this->employeeChildrenRepository->all($request));
    }

    public function store(Request $request)
    {
        $result = $this->employeeChildrenRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildrenInfoResource($result);
    }

    public function show($id)
    {
        $result = $this->employeeChildrenRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildrenInfoResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->employeeChildrenRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildrenInfoResource($result);
    }

    public function destroy($id)
    {
        $result = $this->employeeChildrenRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildrenInfoResource($result);
    }
    public function EmployeeWiseChildren($staffId){

        $result = $this->employeeChildrenRepository->EmployeeWiseChildren($staffId);
        return (is_object(json_decode($result))) === false ? $result :  new EmployeeWiseChildrenCollection($result);
    }
}
