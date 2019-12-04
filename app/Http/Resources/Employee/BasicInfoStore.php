<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Setup\MaritalStatus;
use App\Helpers\Helper;
class BasicInfoStore extends JsonResource
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
            'id' => $this->id,
            'staffId' => $this->staff_id,
            'familyName' => $this->familyName,
            'familyNameBangla' => $this->familyNameBangla,
            'givenName' => $this->givenName,
            'givenNameBangla' => $this->givenNameBangla,
            'genderId' => $this->genderId,
            'maritalStatusId' => $this->maritalStatusId,
            'maritalStatus' => MaritalStatus::where('id', $this->maritalStatusId)->first()?MaritalStatus::where('id',$this->maritalStatusId)->first()->name:'',
            'dateofBirth' => Helper::formatdate($this->dateofBirth),
            'languageId' => $this->languageId,
            'nationalIdNumber' => $this->nationalIdNumber,
            'nationalIdIssueDate' => $this->nationalIdIssueDate,
            'nationalIdExpireDate' => $this->nationalIdExpireDate,
            'countryId' => $this->countryId,
            'divisionId' => $this->divisionId,
            'districtId' => $this->districtId,
            'maritalDate' => $this->maritalDate,
            'employeeImageUrl' => $this->employeeImageUrl,
            'isActive' => $this->isActive,
            'isDefault' => $this->isDefault,
        ];
    }
}
