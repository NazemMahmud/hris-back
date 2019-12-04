<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Setup\MaritalStatus;
use App\Helpers\Helper;
class BasicInfo extends JsonResource
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
            'id' => $info?$info->id:'',
            'staffId' => $info?$info->staff_id:'',
            'familyName' => $info?$info->familyName:'',
            'familyNameBangla' => $info?$info->familyNameBangla:'',
            'givenName' => $info?$info->givenName:'',
            'givenNameBangla' => $info?$info->givenNameBangla:'',
            'genderId' => $info?$info->genderId:'',
            'maritalStatusId' => $info?$info->maritalStatusId:'',
            'maritalStatus' => $info?MaritalStatus::where('id', $info->maritalStatusId)->first()?MaritalStatus::where('id',$info->maritalStatusId)->first()->name:'':'',
            'dateofBirth' => $info?Helper::formatdate($info->dateofBirth):'',
            'languageId' => $info?$info->languageId:'',
            'nationalIdNumber' => $info?$info->nationalIdNumber:'',
            'nationalIdIssueDate' => $info?$info->nationalIdIssueDate:'',
            'nationalIdExpireDate' => $info?$info->nationalIdExpireDate:'',
            'countryId' => $info?$info->countryId:'',
            'divisionId' => $info?$info->divisionId:'',
            'districtId' => $info?$info->districtId:'',
            'maritalDate' => $info?$info->maritalDate:'',
            'employeeImageUrl' => $info?$info->employeeImageUrl:'',
            'isActive' => $info?$info->isActive:'',
            'isDefault' => $info?$info->isDefault:'',
            'requestedData'=>[
                'id' => $requestedData?$requestedData->id:'',
                'staffId' => $requestedData?$requestedData->staff_id:'',
                'familyName' => $requestedData?$requestedData->familyName:'',
                'familyNameBangla' => $requestedData?$requestedData->familyNameBangla:'',
                'givenName' => $requestedData?$requestedData->givenName:'',
                'givenNameBangla' => $requestedData?$requestedData->givenNameBangla:'',
                'genderId' => $requestedData?$requestedData->genderId:'',
                'maritalStatusId' => $requestedData?$requestedData->maritalStatusId:'',
                'maritalStatus' => $requestedData?MaritalStatus::where('id', $requestedData->maritalStatusId)->first()?MaritalStatus::where('id',$requestedData->maritalStatusId)->first()->name:'':'',
                'dateofBirth' => $requestedData?Helper::formatdate($requestedData->dateofBirth):'',
                'languageId' => $requestedData?$requestedData->languageId:'',
                'nationalIdNumber' => $requestedData?$requestedData->nationalIdNumber:'',
                'nationalIdIssueDate' => $requestedData?$requestedData->nationalIdIssueDate:'',
                'nationalIdExpireDate' => $requestedData?$requestedData->nationalIdExpireDate:'',
                'countryId' => $requestedData?$requestedData->countryId:'',
                'divisionId' => $requestedData?$requestedData->divisionId:'',
                'districtId' => $requestedData?$requestedData->districtId:'',
                'maritalDate' => $requestedData?$requestedData->maritalDate:'',
                'employeeImageUrl' => $requestedData?$requestedData->employeeImageUrl:'',
                'isActive' => $requestedData?$requestedData->isActive:'',
                'isDefault' => $requestedData?$requestedData->isDefault:'',
                'status'=> $requestedData?$requestedData->status:'',
                'Accept_or_rejected_by' => $requestedData?$requestedData->Accept_or_rejected_by:'',
                'rejection_reason' => $requestedData?$requestedData->rejection_reason:'',

            ]
        ];
    }
}
