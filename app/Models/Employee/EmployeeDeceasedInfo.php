<?php

namespace App\Models\Employee;

use App\Http\Resources\Base\Collection;
use App\Manager\RedisManager\RedisManager;
use App\Models\Base;
use App\Models\Setup\EmployeeChilden;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setup\EmployeeStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;
class EmployeeDeceasedInfo extends Model
{
    protected $table = "employee_deceased_infos";


    public function getAge($dateOfBirth){
        $d1 = new DateTime($dateOfBirth);
        $d2 = new DateTime();
        $diff = $d2->diff($d1);
        return $diff->y;
    }

    function getDataCollection($employee){
        return [
            "id" => $employee->id,
            "staff_id" => $employee->staff_id,
            "employeeName" => Employee::where('id', $employee->staff_id )->pluck('employeeName')->first(),
            "amount" => $employee->amount,
            "startDate" => date('Y-m-d', strtotime($employee->start_date)),
            "endDate" => date('Y-m-d', strtotime($employee->end_date)),
            "status" => ($employee->status == 0) ? 'Pending' : ($employee->status == 1 ? 'Accepted' : 'Rejected'),
            "created_at" => date('Y-m-d', strtotime($employee->created_at)),
            "updated_at" => date('Y-m-d', strtotime($employee->updated_at)),
            "created_by"=> $employee->created_by,
            "updated_by"=> $employee->updated_by,
            "deleted_by"=> $employee->deleted_by,
            "softDelete"=> $employee->softDelete
        ];
    }


    function getAll($resourcePerPage = 0){
        $resource = ($resourcePerPage == 0) ?
            EmployeeDeceasedInfo::orderBy('status')->get():
            EmployeeDeceasedInfo::orderBy('status')->paginate($resourcePerPage);
        $data = [];
        foreach ($resource as $employee){
            $data[] = $this->getDataCollection($employee);
        }

        return [ 'data' => $data ];
    }

    function store($staffId, $updatedDate, $children){
        $employeeDeceasedMoney = EmployeeDeceasedMoney::pluck('money')->first();
        $dateOfBirth = date('Y-m-d', strtotime($children['dob']));
        $endDate = date('Y-m-d H:i:s', strtotime($dateOfBirth." last day of +25 years"));

        $resource = new EmployeeDeceasedInfo();
        $resource->staff_id = $staffId;
        $resource->amount = $employeeDeceasedMoney;
        $resource->start_date = date('Y-m-d H:i:s', strtotime($updatedDate." first day of next month"));
        $resource->end_date = $endDate;
        $resource->status = 0;
        // $resource->created_by = Auth::user()->staff_id;
        // $resource->updated_by = Auth::user()->staff_id; 
        $resource->created_by = 4;
        $resource->updated_by = 4; 
        $resource->save();

        return $resource; 
    }
    function storeResource($staffId, $updatedDate){
        // check children is available or not
        $isChildren = EmployeeChildrenInfo::where('staff_id', $staffId)->get();
        $data = [];
        if (isset($isChildren)) {
            $counter = 0;
            foreach($isChildren as $children){
                if($this->getAge(date('Y-m-d', strtotime($children->dob))) <=25) {
                    if($counter < 2) {
                        $data[] = $this->store($staffId, date('Y-m-d H:i:s', strtotime($updatedDate)), $children);
                        $counter++;
                    }
                }
            }
        }
    
        return $data;
    }

    function updateResource($request, $id){
        $resource = EmployeeDeceasedInfo::find($id);
        if(empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $resource->amount = (isset($request->amount)) ? $request->amount : $resource->amount;
        if(isset($request->status))
            $resource->status = ($request->status == 'Accept') ? 1 : 2;
        $resource->reason = (isset($request->reason)) ? $request->reason : '';
        $resource->updated_by = Auth::user()->staff_id;
        $resource->updated_at = date('Y-m-d H:i:s');
        $resource->save();
        return $resource;
    }

    function getResourceById($id) {
        $resource = $this->EmployeeDeceasedInfo::find($id);

        if (empty($resource)) return response()->json(['errors' => 'Resource not found'], 404);

        return $resource;
    }

    function updateDeceasedStatus($request, $id){
        $resource = EmployeeDeceasedInfo::find($id);

        $resource->status = $request->status;
        $resource->amount = $request->amount;
        $resource->start_date = $request->start_date;
        $resource->end_date = $request->end_date;
        $resource->updated_at = $request->updated_at;
        $resource->updated_by = $request->updated_by;

        $resource->save();
        return ['data' =>  $this->getDataCollection($resource)];
    }
    
}
