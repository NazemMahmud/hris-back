<?php

namespace App\Models\Employee;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Employee\EmployeeFamilyMemberInfoUpdateRequest;
class EmployeeFamilyMemberInfo extends Base
{
    public function __construct($arrtibutes = array())
    {
        parent::__construct($this);
        $this->fill($arrtibutes);
    }
    protected $fillable = [
        'staff_id','employee_mother_name','employee_mother_occupation_id','employee_father_name','employee_father_occupation_id',

        'address', 'dob', 'gender_id', 'phone_no',
        'nid', 'birth_certification_no',
        'spouse_position', 'spouse_company', 'spouse_phone_no',
        'spouse_occupation', 'spouse_national_id', 'spouse_dob',
        'spouse_name',  'employee_mother_dob',
        'employee_mother_phone_no', 'employee_mother_address',
        'employee_father_dob','employee_father_phone_no',
        'employee_father_address'
    ];

    /**
     * @param $request
     * @return EmployeeContactInfo
     */
    function storeResource($request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'employee_mother_name' => 'required',
            'employee_mother_occupation_id' => 'required',
            'employee_father_name' => 'required',
            'employee_father_occupation_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);
        $resource = EmployeeFamilyMemberInfo::where('staff_id', '=', $request->staff_id )->first();
        if (empty($resource)){
            $resource = new EmployeeFamilyMemberInfo();
            $resource->staff_id = $request->staff_id;
        }
        $resource->employee_mother_name = $request->employee_mother_name;
        $resource->employee_mother_occupation_id = $request->employee_mother_occupation_id;
        $resource->employee_father_name = $request->employee_father_name;
        $resource->employee_father_occupation_id = $request->employee_father_occupation_id;


        if ($request->has('gender_id')){
            $resource->gender_id = $request->gender_id;
        }
        if ($request->has('phone_no')){
            $resource->phone_no = $request->phone_no;
        }
        if ($request->has('nid')){
            $resource->nid = $request->nid;
        }
        if ($request->has('birth_certification_no')){
            $resource->birth_certification_no = $request->birth_certification_no;
        }
        if ($request->has('spouse_position')){
            $resource->spouse_position = $request->spouse_position;
        }
        if ($request->has('spouse_company')){
            $resource->spouse_company = $request->spouse_company;
        }
        if ($request->has('spouse_phone_no')){
            $resource->spouse_phone_no = $request->spouse_phone_no;
        }
        if ($request->has('spouse_occupation')){
            $resource->spouse_occupation = $request->spouse_occupation;
        }
        if ($request->has('spouse_national_id')){
            $resource->spouse_national_id = $request->spouse_national_id;
        }
        if ($request->has('spouse_dob')){
            $resource->spouse_dob = Helper::formatdate($request->spouse_dob);
        }
        if ($request->has('spouse_name')){
            $resource->spouse_name = $request->spouse_name;
        }
        if ($request->has('employee_mother_dob')){
            $resource->employee_mother_dob = Helper::formatdate($request->employee_mother_dob);
        }
        if ($request->has('employee_mother_phone_no')){
            $resource->employee_mother_phone_no = $request->employee_mother_phone_no;
        }
        if ($request->has('employee_mother_address')){
            $resource->employee_mother_address = $request->employee_mother_address;
        }
        if ($request->has('employee_father_dob')){
            $resource->employee_father_dob = Helper::formatdate($request->employee_father_dob);
        }
        if ($request->has('employee_father_phone_no')){
            $resource->employee_father_phone_no = $request->employee_father_phone_no;
        }
        if ($request->has('employee_father_address')){
            $resource->employee_father_address = $request->employee_father_address;
        }

        $resource->save();

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'employee_mother_name' => 'required',
            'employee_mother_occupation_id' => 'required',
            'employee_father_name' => 'required',
            'employee_father_occupation_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $data['info'] = $this->model::where('staff_id', $id)->first();

        if (empty($data['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        $resource = EmployeeFamilyMemberInfoUpdateRequest::where('staff_id', '=', $request->staff_id)->first();

        if(empty($resource)){
            $resource = new EmployeeFamilyMemberInfoUpdateRequest();
            $resource->staff_id = $request->staff_id;
        }

        $resource->employee_mother_name = $request->employee_mother_name;
        $resource->employee_mother_occupation_id = $request->employee_mother_occupation_id;
        $resource->employee_father_name = $request->employee_father_name;
        $resource->employee_father_occupation_id = $request->employee_father_occupation_id;
        $resource->family_member_info_id = $data['info']->id;

        if ($request->has('gender_id')){
            $resource->gender_id = $request->gender_id;
        }
        if ($request->has('phone_no')){
            $resource->phone_no = $request->phone_no;
        }
        if ($request->has('nid')){
            $resource->nid = $request->nid;
        }
        if ($request->has('birth_certification_no')){
            $resource->birth_certification_no = $request->birth_certification_no;
        }
        if ($request->has('spouse_position')){
            $resource->spouse_position = $request->spouse_position;
        }
        if ($request->has('spouse_company')){
            $resource->spouse_company = $request->spouse_company;
        }

        if ($request->has('spouse_phone_no')){
            $resource->spouse_phone_no = $request->spouse_phone_no;
        }
        if ($request->has('spouse_occupation')){
            $resource->spouse_occupation = $request->spouse_occupation;
        }
        if ($request->has('spouse_national_id')){
            $resource->spouse_national_id = $request->spouse_national_id;
        }
        if ($request->has('spouse_dob')){
            $resource->spouse_dob = Helper::formatdate($request->spouse_dob);
        }
        if ($request->has('spouse_name')){
            $resource->spouse_name = $request->spouse_name;
        }
        if ($request->has('employee_mother_dob')){
            $resource->employee_mother_dob = Helper::formatdate($request->employee_mother_dob);
        }
        if ($request->has('employee_mother_phone_no')){
            $resource->employee_mother_phone_no = $request->employee_mother_phone_no;
        }
        if ($request->has('employee_mother_address')){
            $resource->employee_mother_address = $request->employee_mother_address;
        }
        if ($request->has('employee_father_dob')){
            $resource->employee_father_dob = Helper::formatdate($request->employee_father_dob);
        }
        if ($request->has('employee_father_phone_no')){
            $resource->employee_father_phone_no = $request->employee_father_phone_no;
        }
        if ($request->has('employee_father_address')){
            $resource->employee_father_address = $request->employee_father_address;
        }

        $resource->status = 0;

        $resource->save();

        $data['info'] = $this->model::where('staff_id', $id)->first();
        $data['request'] = $resource;

        return $data;
    }

    function getEmployeeInfoById($id) {

        $resource['info'] = EmployeeFamilyMemberInfo::where('staff_id', '=', $id)->first();

        if (empty($resource['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        $resource['request'] = EmployeeFamilyMemberInfoUpdateRequest::where('staff_id', $id)->first();

        return $resource;
    }

    function deleteEmployeeFamilyInfoById($id) {

         $resource = EmployeeFamilyMemberInfo::where('staff_id', '=', $id)->first();

        if (empty($resource)) return response()->json(['message' => 'Resource not found.'], 404);

        $resource->delete();

        return $resource;
    }
    function getEmployeeInfo($staff_id) {

        return EmployeeFamilyMemberInfo::where('staff_id', '=', $staff_id)->first();
    }
}
