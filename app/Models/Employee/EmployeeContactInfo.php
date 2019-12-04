<?php

namespace App\Models\Employee;

use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Base\BaseCollection;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\EmployeeContactInfoUpdateRequest;
class EmployeeContactInfo extends Base
{
    public function __construct($arrtibutes = array())
    {
        parent::__construct($this);
        $this->fill($arrtibutes);
    }
    protected $fillable = [
        'staff_id',
        'office_phone_no_1', 'company_email',

        'home_phone_no', 'extension_no', 'personal_email',

        'second_contact_name', 'phone_no_01','phone_no_2',

        'permanent_address','permanent_address_country_id','permanent_address_division_id',
        'permanent_address_district_id', 'permanent_address_city_id', 'permanent_thana','present_address','present_address_country_id',

        'present_address_division', 'present_address_district_id', 'present_thana','present_address_city_id',
        'permanent_address_street', 'permanent_address_village', 'permanent_address_house_no', 'present_address_street',
        'present_address_village','present_address_house_no',

        'office_address_no_1','office_address_no_2','office_address_no_3','relationship',
        'emergency_contact_name','emergency_contact_no_1','emergency_contact_no_2','isActive','isDefault'
    ];
    /**
     * @param $request
     * @return EmployeeContactInfo
     */
    function storeResource($request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'office_phone_no_1' => 'required',
            'company_email' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404);
        
        $resource = EmployeeContactInfo::where('staff_id', '=', $request->staff_id )->first();

        if (empty($resource)){
            $resource = new EmployeeContactInfo();
        }
        $resource->staff_id = $request->staff_id;
        $resource->office_phone_no_1 = $request->office_phone_no_1;
        $resource->company_email = $request->company_email;

        if ($request->has('home_phone_no')){
            $resource->home_phone_no = $request->home_phone_no;
        }
        if ($request->has('extension_no')){
            $resource->extension_no = $request->extension_no;
        }
        if ($request->has('personal_email')){
            $resource->personal_email = $request->personal_email;
        }
        if ($request->has('second_contact_name')){
            $resource->second_contact_name = $request->second_contact_name;
        }
        if ($request->has('phone_no_01')){
            $resource->phone_no_01 = $request->phone_no_01;
        }
        if ($request->has('phone_no_2')){
            $resource->phone_no_2 = $request->phone_no_2;
        }
        if ($request->has('permanent_address')){
            $resource->permanent_address = $request->permanent_address;
        }
        if ($request->has('permanent_address_country_id')){
            $resource->permanent_address_country_id = $request->permanent_address_country_id;
        }
        if ($request->has('permanent_address_division_id')){
            $resource->permanent_address_division_id = $request->permanent_address_division_id;
        }
        if ($request->has('permanent_address_district_id')){
            $resource->permanent_address_district_id = $request->permanent_address_district_id;
        }
        if ($request->has('permanent_address_city_id')){
            $resource->permanent_address_city_id = $request->permanent_address_city_id;
        }
        if ($request->has('permanent_thana')){
            $resource->permanent_thana = $request->permanent_thana;
        }
        if ($request->has('present_address')){
            $resource->present_address = $request->present_address;
        }
        if ($request->has('present_address_country_id')){
            $resource->present_address_country_id = $request->present_address_country_id;
        }
        if ($request->has('present_address_division_id')){
            $resource->present_address_division_id = $request->present_address_division_id;
        }
        if ($request->has('office_phone_no_2')){
            $resource->office_phone_no_2 = $request->office_phone_no_2;
        }
        if ($request->has('office_phone_no_3')){
            $resource->office_phone_no_3 = $request->office_phone_no_3;
        }

        if ($request->has('present_address_district_id')){
            $resource->present_address_district_id = $request->present_address_district_id;
        }
        if ($request->has('present_thana')){
            $resource->present_thana = $request->present_thana;
        }
        if ($request->has('present_address_city_id')){
            $resource->present_address_city_id = $request->present_address_city_id;
        }
        if ($request->has('permanent_address_street')){
            $resource->permanent_address_street = $request->permanent_address_street;
        }
        if ($request->has('permanent_address_village')){
            $resource->permanent_address_village = $request->permanent_address_village;
        }
        if ($request->has('permanent_address_house_no')){
            $resource->permanent_address_house_no = $request->permanent_address_house_no;
        }
        if ($request->has('present_address_street')){
            $resource->present_address_street = $request->present_address_street;
        }
        if ($request->has('present_address_village')){
            $resource->present_address_village = $request->present_address_village;
        }
        if ($request->has('present_address_house_no')){
            $resource->present_address_house_no = $request->present_address_house_no;
        }
        if ($request->has('office_address_no_1')){
            $resource->office_address_no_1 = $request->office_address_no_1;
        }
        if ($request->has('office_address_no_2')){
            $resource->office_address_no_2 = $request->office_address_no_2;
        }
        if ($request->has('office_address_no_3')){
            $resource->office_address_no_3 = $request->office_address_no_3;
        }
        if ($request->has('relationship')){
            $resource->relationship = $request->relationship;
        }
        if ($request->has('emergency_contact_name')){
            $resource->emergency_contact_name = $request->emergency_contact_name;
        }
        if ($request->has('emergency_contact_no_1')){
            $resource->emergency_contact_no_1 = $request->emergency_contact_no_1;
        }
        if ($request->has('emergency_contact_no_2')){
            $resource->emergency_contact_no_2 = $request->emergency_contact_no_2;
        }
        if ($request->has('isActive')){
            $resource->isActive = $request->isActive;
        }
        if ($request->has('isDefault')){
            $resource->isDefault = $request->isDefault;
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
            'office_phone_no_1' => 'required',
            'company_email' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $data['info'] = $this->model::where('staff_id',  $request->staff_id)->first();

        if (empty($data['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        $resource = EmployeeContactInfoUpdateRequest::where('staff_id', '=', $request->staff_id)->first();


        if(empty($resource)){
            $resource = new EmployeeContactInfoUpdateRequest();
        }

        $resource->staff_id = $request->staff_id;
        $resource->office_phone_no_1 = $request->office_phone_no_1;
        $resource->company_email = $request->company_email;
        $resource->contact_info_id = $data['info']->id;

        if ($request->has('home_phone_no')){
            $resource->home_phone_no = $request->home_phone_no;
        }
        if ($request->has('office_phone_no_2')){
            $resource->office_phone_no_2 = $request->office_phone_no_2;
        }
        if ($request->has('office_phone_no_3')){
            $resource->office_phone_no_3 = $request->office_phone_no_3;
        }
        if ($request->has('extension_no')){
            $resource->extension_no = $request->extension_no;
        }
        if ($request->has('personal_email')){
            $resource->personal_email = $request->personal_email;
        }
        if ($request->has('second_contact_name')){
            $resource->second_contact_name = $request->second_contact_name;
        }
        if ($request->has('phone_no_01')){
            $resource->phone_no_01 = $request->phone_no_01;
        }
        if ($request->has('phone_no_2')){
            $resource->phone_no_2 = $request->phone_no_2;
        }
        if ($request->has('permanent_address')){
            $resource->permanent_address = $request->permanent_address;
        }
        if ($request->has('permanent_address_country_id')){
            $resource->permanent_address_country_id = $request->permanent_address_country_id;
        }
        if ($request->has('permanent_address_division_id')){
            $resource->permanent_address_division_id = $request->permanent_address_division_id;
        }
        if ($request->has('permanent_address_district_id')){
            $resource->permanent_address_district_id = $request->permanent_address_district_id;
        }
        if ($request->has('permanent_address_city_id')){
            $resource->permanent_address_city_id = $request->permanent_address_city_id;
        }

        if ($request->has('permanent_thana')){
            $resource->permanent_thana = $request->permanent_thana;
        }
        if ($request->has('present_address')){
            $resource->present_address = $request->present_address;
        }
        if ($request->has('present_address_country_id')){
            $resource->present_address_country_id = $request->present_address_country_id;
        }
        if ($request->has('present_address_division_id')){
            $resource->present_address_division_id = $request->present_address_division_id;
        }

        if ($request->has('present_address_district_id')){
            $resource->present_address_district_id = $request->present_address_district_id;
        }
//        if ($request->has('present_thana')){
//            $resource->present_thana = $request->present_thana;
//        }
        if ($request->has('present_address_city_id')){
            $resource->present_address_city_id = $request->present_address_city_id;
        }
        if ($request->has('permanent_address_street')){
            $resource->permanent_address_street = $request->permanent_address_street;
        }
        if ($request->has('permanent_address_village')){
            $resource->permanent_address_village = $request->permanent_address_village;
        }
        if ($request->has('permanent_address_house_no')){
            $resource->permanent_address_house_no = $request->permanent_address_house_no;
        }
        if ($request->has('present_address_street')){
            $resource->present_address_street = $request->present_address_street;
        }
        if ($request->has('present_address_village')){
            $resource->present_address_village = $request->present_address_village;
        }
        if ($request->has('present_address_house_no')){
            $resource->present_address_house_no = $request->present_address_house_no;
        }
        if ($request->has('office_address_no_1')){
            $resource->office_address_no_1 = $request->office_address_no_1;
        }
        if ($request->has('office_address_no_2')){
            $resource->office_address_no_2 = $request->office_address_no_2;
        }
        if ($request->has('office_address_no_3')){
            $resource->office_address_no_3 = $request->office_address_no_3;
        }
        if ($request->has('relationship')){
            $resource->relationship = $request->relationship;
        }
        if ($request->has('emergency_contact_name')){
            $resource->emergency_contact_name = $request->emergency_contact_name;
        }
        if ($request->has('emergency_contact_no_1')){
            $resource->emergency_contact_no_1 = $request->emergency_contact_no_1;
        }
        if ($request->has('emergency_contact_no_2')){
            $resource->emergency_contact_no_2 = $request->emergency_contact_no_2;
        }
        if ($request->has('isActive')){
            $resource->isActive = $request->isActive;
        }
        if ($request->has('isDefault')){
            $resource->isDefault = $request->isDefault;
        }

        $resource->status = 0;
        $resource->save();

        $data['info'] = $this->model::where('staff_id', $id)->first();
        $data['request'] = $resource;

        return $data;
    }

    public function NotUserEmployee()
    {
        $not_users_employee_base_user = DB::table("employees")->select('id', 'employeeName AS label')
            ->whereNotIn('id', function ($query) {
                $query->select('staff_id')->from('users');
            })->get();
        return new BaseCollection($not_users_employee_base_user);
    }


    function getEmployeeInfoById($id) {

        $resource['info'] = EmployeeContactInfo::where('staff_id', '=', $id)->first();

        if (empty($resource['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        $resource['request'] = EmployeeContactInfoUpdateRequest::where('staff_id', $id)->first();

        return $resource;
    }
    function getEmployeeContactInfo($staff_id) {

        return EmployeeContactInfo::where('staff_id', '=', $staff_id)->first();

    }

    function deleteEmployeeInfoById($id) {
        $resource = EmployeeContactInfo::where('staff_id', '=', $id)->first();

        if (empty($resource)) return response()->json(['message' => 'Resource not found.'], 404);

        $resource->delete();

        return $resource;
    }
}
