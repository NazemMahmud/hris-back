<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeContactInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $info = $data['info']?$data['info']:$data;
        $requestedData = $data['request'];

        return [
            "id"=> $info->id,
            "staff_id"=> $info->staff_id,
            "home_phone_no"=> $info->home_phone_no,
            "extension_no"=> $info->extension_no,
            "personal_email"=> $info->personal_email,
            "company_email"=> $info->company_email,
            "second_contact_name"=> $info->second_contact_name,
            "phone_no_01"=> $info->phone_no_01,
            "phone_no_2"=> $info->phone_no_2,
            "permanent_address"=> $info->permanent_address,
            "permanent_address_country_id"=> $info->permanent_address_country_id,
            "permanent_address_division_id"=> $info->permanent_address_division_id,
            "permanent_address_district_id"=> $info->permanent_address_district_id,
            "permanent_thana"=> $info->permanent_thana,
            "permanent_address_city_id"=> $info->permanent_address_city_id,
            "present_address"=> $info->present_address,
            "present_address_country_id"=> $info->present_address_country_id,
            "present_address_division"=> $info->present_address_division,
            "present_address_district_id"=> $info->present_address_district_id,
            "present_thana"=> $info->present_thana,
            "present_address_city_id"=> $info->present_address_city_id,
            "office_phone_no_1"=> $info->office_phone_no_1,
            "office_phone_no_2"=> $info->office_phone_no_2,
            "office_phone_no_3"=> $info->office_phone_no_3,
            "relationship"=> $info->relationship,
            "emergency_contact_name"=> $info->emergency_contact_name,
            "emergency_contact_no_1"=> $info->emergency_contact_no_1,
            "emergency_contact_no_2"=> $info->emergency_contact_no_2,
            "permanent_address_street"=> $info->permanent_address_street,
            "permanent_address_village"=> $info->permanent_address_village,
            "permanent_address_house_no"=> $info->permanent_address_house_no,
            "present_address_street"=> $info->present_address_street,
            "present_address_village"=> $info->present_address_village,
            "present_address_house_no"=> $info->present_address_house_no,
            "isActive"=> $info->isActive,
            "isDefault"=> $info->isDefault,
            "created_at"=> $info->created_at,
            "updated_at"=> $info->updated_at,
            'requestedData'=>[
                "id"=> $requestedData?$requestedData->id:"",
                "staff_id"=> $requestedData?$requestedData->staff_id:"",
                "home_phone_no"=> $requestedData?$requestedData->home_phone_no:"",
                "extension_no"=> $requestedData?$requestedData->extension_no:"",
                "personal_email"=> $requestedData?$requestedData->personal_email:"",
                "company_email"=> $requestedData?$requestedData->company_email:"",
                "second_contact_name"=> $requestedData?$requestedData->second_contact_name:"",
                "phone_no_01"=> $requestedData?$requestedData->phone_no_01:"",
                "phone_no_2"=> $requestedData?$requestedData->phone_no_2:"",
                "permanent_address"=> $requestedData?$requestedData->permanent_address:"",
                "permanent_address_country_id"=> $requestedData?$requestedData->permanent_address_country_id:"",
                "permanent_address_division_id"=> $requestedData?$requestedData->permanent_address_division_id:"",
                "permanent_address_district_id"=> $requestedData?$requestedData->permanent_address_district_id:"",
                "permanent_thana"=> $requestedData?$requestedData->permanent_thana:"",
                "permanent_address_city_id"=> $requestedData?$requestedData->permanent_address_city_id:"",
                "present_address"=> $requestedData?$requestedData->present_address:"",
                "present_address_country_id"=> $requestedData?$requestedData->present_address_country_id:"",
                "present_address_division"=> $requestedData?$requestedData->present_address_division:"",
                "present_address_district_id"=> $requestedData?$requestedData->present_address_district_id:"",
                "present_thana"=> $requestedData?$requestedData->present_thana:"",
                "present_address_city_id"=> $requestedData?$requestedData->present_address_city_id:"",
                "office_phone_no_1"=> $requestedData?$requestedData->office_phone_no_1:"",
                "office_phone_no_2"=> $requestedData?$requestedData->office_phone_no_2:"",
                "office_phone_no_3"=> $requestedData?$requestedData->office_phone_no_3:"",
                "relationship"=> $requestedData?$requestedData->relationship:"",
                "emergency_contact_name"=> $requestedData?$requestedData->emergency_contact_name:"",
                "emergency_contact_no_1"=> $requestedData?$requestedData->emergency_contact_no_1:"",
                "emergency_contact_no_2"=> $requestedData?$requestedData->emergency_contact_no_2:"",
                "permanent_address_street"=> $requestedData?$requestedData->permanent_address_street:"",
                "permanent_address_village"=> $requestedData?$requestedData->permanent_address_village:"",
                "permanent_address_house_no"=> $requestedData?$requestedData->permanent_address_house_no:"",
                "present_address_street"=> $requestedData?$requestedData->present_address_street:"",
                "present_address_village"=> $requestedData?$requestedData->present_address_village:"",
                "present_address_house_no"=> $requestedData?$requestedData->present_address_house_no:"",
                "isActive"=> $requestedData?$requestedData->isActive:"",
                "isDefault"=> $requestedData?$requestedData->isDefault:"",
                "created_at"=> $requestedData?$requestedData->created_at:"",
                "updated_at"=> $requestedData?$requestedData->updated_at:"",
                "status"=> $requestedData?$requestedData->status:"",
                'Accept_or_rejected_by' => $requestedData?$requestedData->Accept_or_rejected_by:'',
                'rejection_reason' => $requestedData?$requestedData->rejection_reason:'',
            ]
        ];
    }
}
