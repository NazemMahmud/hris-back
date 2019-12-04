<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeContactInfoStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "staff_id"=> $this->staff_id,
            "home_phone_no"=> $this->home_phone_no,
            "extension_no"=> $this->extension_no,
            "personal_email"=> $this->personal_email,
            "company_email"=> $this->company_email,
            "second_contact_name"=> $this->second_contact_name,
            "phone_no_01"=> $this->phone_no_01,
            "phone_no_2"=> $this->phone_no_2,
            "permanent_address"=> $this->permanent_address,
            "permanent_address_country_id"=> $this->permanent_address_country_id,
            "permanent_address_division_id"=> $this->permanent_address_division_id,
            "permanent_address_district_id"=> $this->permanent_address_district_id,
            "permanent_thana"=> $this->permanent_thana,
            "permanent_address_city_id"=> $this->permanent_address_city_id,
            "present_address"=> $this->present_address,
            "present_address_country_id"=> $this->present_address_country_id,
            "present_address_division"=> $this->present_address_division,
            "present_address_district_id"=> $this->present_address_district_id,
            "present_thana"=> $this->present_thana,
            "present_address_city_id"=> $this->present_address_city_id,
            "office_phone_no_1"=> $this->office_phone_no_1,
            "office_phone_no_2"=> $this->office_phone_no_2,
            "office_phone_no_3"=> $this->office_phone_no_3,
            "relationship"=> $this->relationship,
            "emergency_contact_name"=> $this->emergency_contact_name,
            "emergency_contact_no_1"=> $this->emergency_contact_no_1,
            "emergency_contact_no_2"=> $this->emergency_contact_no_2,
            "permanent_address_street"=> $this->permanent_address_street,
            "permanent_address_village"=> $this->permanent_address_village,
            "permanent_address_house_no"=> $this->permanent_address_house_no,
            "present_address_street"=> $this->present_address_street,
            "present_address_village"=> $this->present_address_village,
            "present_address_house_no"=> $this->present_address_house_no,
            "isActive"=> $this->isActive,
            "isDefault"=> $this->isDefault,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
