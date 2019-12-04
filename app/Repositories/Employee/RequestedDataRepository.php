<?php

namespace App\Repositories\Employee;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Employee\EmployeeInfo;
use App\Models\Employee\BasicInfoUpdateRequest;
use App\Models\Employee\EmployeeContactInfoUpdateRequest;
use App\Models\Employee\EmployeeInfoUpdateRequest;
use App\Models\Employee\EmployeeFamilyMemberInfoUpdateRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContactInfo;
use App\Models\Employee\EmployeeFamilyMemberInfo;
use App\Models\Employee\BasicInfo;
use Illuminate\Http\Request;

class RequestedDataRepository
{
    private $requisition;

    public function __construct(BasicInfoUpdateRequest $basicInfoUpdateRequest,
                                EmployeeContactInfoUpdateRequest $employeeContactInfoUpdateRequest,
                                EmployeeInfoUpdateRequest $employeeInfoUpdateRequest,
                                EmployeeInfo $employeeInfo,
                                EmployeeFamilyMemberInfoUpdateRequest $employeeFamilyMemberInfoUpdateRequest,
                                EmployeeContactInfo $employeeContactInfo,
                                EmployeeFamilyMemberInfo $employeeFamilyMemberInfo,
                                BasicInfo $basicInfo
    )
    {
        $this->basicInfoUpdateRequest = $basicInfoUpdateRequest;
        $this->employeeContactInfoUpdateRequest = $employeeContactInfoUpdateRequest;
        $this->employeeInfoUpdateRequest = $employeeInfoUpdateRequest;
        $this->employeeFamilyMemberInfoUpdateRequest = $employeeFamilyMemberInfoUpdateRequest;

        $this->employeeInfo = $employeeInfo;
        $this->basicInfo = $basicInfo;
        $this->employeeContactInfo = $employeeContactInfo;
        $this->employeeFamilyMemberInfo = $employeeFamilyMemberInfo;

    }
    public function basicInfoPendingUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();
        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $basicInfo = $this->basicInfoUpdateRequest->basicInfoUpdateRequest($employeeUnderLineManager->staff_id);
            if(!empty($basicInfo)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }
        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }
    public function contactInfoPendingUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $contactRequestData = $this->employeeContactInfoUpdateRequest->employeeContactRequested($employeeUnderLineManager->staff_id);
            if(!empty($contactRequestData)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }
    public function familyInfoPendingUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $familyInfo = $this->employeeFamilyMemberInfoUpdateRequest->employeeFamilyMemberInfoUpdateRequest($employeeUnderLineManager->staff_id);
            if(!empty($familyInfo)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }
    public function educationInfoUpdateRequest($line_manager_id)
    {
        //return $this->getRequestedUnderDataLineManager($line_manager_id,"educationInfo");
    }
    public function employeeInfoPendingUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $familyInfo = $this->employeeInfoUpdateRequest->employeeInfoPendingUpdateRequest($employeeUnderLineManager->staff_id);
            if(!empty($familyInfo)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }

    public function basicInfoHistoryUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();
        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $basicInfo = $this->basicInfoUpdateRequest->basicInfoHistoryUpdateRequest($employeeUnderLineManager->staff_id);
            if(!empty($basicInfo)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }
        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }
    public function contactInfoHistoryUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $contactRequestData = $this->employeeContactInfoUpdateRequest->employeeContactHistoryRequested($employeeUnderLineManager->staff_id);
            if(!empty($contactRequestData)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }
    public function familyInfoHistoryUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $familyInfo = $this->employeeFamilyMemberInfoUpdateRequest->employeeFamilyMemberInfoHistoryUpdateRequest($employeeUnderLineManager->staff_id);
            if(!empty($familyInfo)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }

    public function employeeInfoHistoryUpdateRequest($line_manager_id)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){
            $familyInfo = $this->employeeInfoUpdateRequest->employeeInfoHistoryUpdateRequest($employeeUnderLineManager->staff_id);
            if(!empty($familyInfo)){
                array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }


    public function getRequestedDataUnderLineManager($line_manager_id,$request_type)
    {
        $employeeUnderLineManagers = $this->EmployeeUnderLineManager($line_manager_id);
        $requestedEmployeeData=array();

        foreach($employeeUnderLineManagers as $employeeUnderLineManager){

            if($request_type == "contactInfo"){
                $contactRequestData = $this->employeeContactInfoUpdateRequest->employeeContactRequested($employeeUnderLineManager->staff_id);
                if(!empty($contactRequestData)){
                    array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
                }
            }
            if($request_type =="familyInfo"){
                $familyInfo = $this->employeeFamilyMemberInfoUpdateRequest->employeeFamilyMemberInfoUpdateRequest($employeeUnderLineManager->staff_id);
                if(!empty($familyInfo)){
                    array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
                }
            }
            if($request_type =="basicInfo"){
                $basicInfo = $this->basicInfoUpdateRequest->basicInfoUpdateRequest($employeeUnderLineManager->staff_id);
                if(!empty($basicInfo)){
                    array_push($requestedEmployeeData,$employeeUnderLineManager->staff_id);
                }
            }
        }

        return $this->getEmployeeDataFromId($requestedEmployeeData);
    }

    public function EmployeeUnderLineManager($line_manager_id){
        return EmployeeInfo::where('lineManager_1st',$line_manager_id)->get();
    }
    public function getEmployeeDataFromId($staff_id){
        return Employee::select('employeeName','id')->whereIn('id',$staff_id)->get();
    }



    public function basicInfoUpdateRequest(Request $request, $staff_id){
        if ($request->status=='1' || $request->status=='accepted' || $request->status=='accept'){
            return $this->basicInfoRequestAccepted($request, $staff_id);
        }
        return $this->basicInfoRequestRejected($request, $staff_id);
    }

    public function basicInfoRequestAccepted($request, $staff_id){
        $requestedData = $this->basicInfoUpdateRequest->basicInfoRequest($staff_id);
        $basicInfo = $this->basicInfo->getBasicInfoData($staff_id);
        if (!empty($requestedData) && !empty($basicInfo)){
            $basicInfo->employee_email = $this->CheckUpdatedInfoNotNull($basicInfo->employee_email,$requestedData->employee_email);
            $basicInfo->familyName = $this->CheckUpdatedInfoNotNull($basicInfo->familyName,$requestedData->familyName);
            $basicInfo->givenName = $this->CheckUpdatedInfoNotNull($basicInfo->givenName,$requestedData->givenName);
            $basicInfo->familyNameBangla = $this->CheckUpdatedInfoNotNull($basicInfo->familyNameBangla,$requestedData->familyNameBangla);
            $basicInfo->givenNameBangla = $this->CheckUpdatedInfoNotNull($basicInfo->givenNameBangla,$requestedData->givenNameBangla);
            $basicInfo->genderId = $this->CheckUpdatedInfoNotNull($basicInfo->genderId,$requestedData->genderId);
            $basicInfo->maritalStatusId = $this->CheckUpdatedInfoNotNull($basicInfo->maritalStatusId,$requestedData->maritalStatusId);
            $basicInfo->dateofBirth = $this->CheckUpdatedInfoNotNull($basicInfo->dateofBirth,$requestedData->dateofBirth);
            $basicInfo->languageId = $this->CheckUpdatedInfoNotNull($basicInfo->languageId, $requestedData->languageId);
            $basicInfo->nationalIdNumber = $this->CheckUpdatedInfoNotNull($basicInfo->nationalIdNumber,$requestedData->nationalIdNumber);
            $basicInfo->countryId = $this->CheckUpdatedInfoNotNull($basicInfo->countryId,$requestedData->countryId);
            $basicInfo->divisionId = $this->CheckUpdatedInfoNotNull($basicInfo->divisionId,$requestedData->divisionId);
            $basicInfo->districtId = $this->CheckUpdatedInfoNotNull($basicInfo->districtId,$requestedData->districtId);
            $basicInfo->maritalDate = $this->CheckUpdatedInfoNotNull($basicInfo->maritalDate, $requestedData->maritalDate);
            $basicInfo->employeeImageUrl = $this->CheckUpdatedInfoNotNull($basicInfo-employeeImageUrl,$requestedData->employeeImageUrl);
            $basicInfo->save();
            $requestedData->status = 1;
            $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by:null;
            $requestedData->save();
            //send a mail while accept request
            return response()->json(['message' => 'accepted.'], 200);
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }
    public function CheckUpdatedInfoNotNull($data,$requestedData){
        return $requestedData == null ? $data : $requestedData;

    }
    public function basicInfoRequestRejected($request, $staff_id){

        $requestedData =  $this->basicInfoUpdateRequest->basicInfoRequestRejected($staff_id);
        if (empty($requestedData)) return response()->json(['errors' => 'Resource not found'], 404);
        $requestedData->status = 2;
        $request->has('rejection_reason')? $requestedData->rejection_reason =$request->rejection_reason:null;
        $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by:null;
        $requestedData->save();
        //send a mail while Reject request
        return response()->json(['message' => 'Rejected.'], 200);
    }

    public function contactInfoUpdateRequest(Request $request, $staff_id){
        if ($request->status=='1' || $request->status=='accepted' || $request->status=='accept'){
            return $this->contactInfoRequestAccepted($request, $staff_id);
        }
        return $this->contactInfoRequestRejected($request, $staff_id);

    }
    public function contactInfoRequestRejected($request, $staff_id){

        $requestedData = $this->employeeContactInfoUpdateRequest->employeeContactInfoRequested($staff_id);
        if (empty($requestedData)) return response()->json(['errors' => 'Resource not found'], 404);
        $requestedData->status = 2;
        $request->has('rejection_reason')? $requestedData->rejection_reason =$request->rejection_reason:null;
        $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by:null;
        $requestedData->save();
        //send a mail while Reject request
        return response()->json(['message' => 'Rejected.'], 200);
    }
    public function contactInfoRequestAccepted($request, $staff_id){
        $requestedData = $this->employeeContactInfoUpdateRequest->employeeContactInfoRequested($staff_id);
        $contactInfo = $this->employeeContactInfo->getEmployeeContactInfo($staff_id);
        if (!empty($requestedData) && !empty($contactInfo)){
            $contactInfo->home_phone_no = $requestedData->home_phone_no;
            $contactInfo->extension_no = $requestedData->extension_no;
            $contactInfo->personal_email = $requestedData->personal_email;
            $contactInfo->company_email = $requestedData->company_email;
            $contactInfo->second_contact_name = $requestedData->second_contact_name;
            $contactInfo->phone_no_01 = $requestedData->phone_no_01;
            $contactInfo->phone_no_2 = $requestedData->phone_no_2;
            $contactInfo->permanent_address = $requestedData->permanent_address;
            $contactInfo->permanent_address_country_id = $requestedData->permanent_address_country_id;
            $contactInfo->permanent_address_division_id = $requestedData->permanent_address_division_id;
            $contactInfo->permanent_address_district_id = $requestedData->permanent_address_district_id;
            $contactInfo->permanent_thana = $requestedData->permanent_address_thana;
            $contactInfo->permanent_address_city_id = $requestedData->permanent_address_city_id;
            $contactInfo->present_address = $requestedData->present_address;
            $contactInfo->present_address_country_id = $requestedData->present_address_country_id;
            $contactInfo->present_address_division = $requestedData->present_address_division_id;
            $contactInfo->present_address_district_id = $requestedData->present_address_district_id;
            $contactInfo->present_thana = $requestedData->present_address_thana;
            $contactInfo->present_address_city_id = $requestedData->present_address_city_id;
            $contactInfo->relationship = $requestedData->relationship;
            $contactInfo->emergency_contact_name = $requestedData->emergency_contact_name;
            $contactInfo->emergency_contact_no_1 = $requestedData->emergency_contact_no_1;
            $contactInfo->emergency_contact_no_2 = $requestedData->emergency_contact_no_2;
            $contactInfo->office_phone_no_1 = $requestedData->office_phone_no_1;
            $contactInfo->office_phone_no_2 = $requestedData->office_phone_no_2;
            $contactInfo->office_phone_no_3 = $requestedData->office_phone_no_3;
            $contactInfo->permanent_address_street = $requestedData->permanent_address_street;
            $contactInfo->permanent_address_village = $requestedData->permanent_address_village;
            $contactInfo->permanent_address_house_no = $requestedData->permanent_address_house_no;
            $contactInfo->permanent_thana = $requestedData->permanent_thana;
            $contactInfo->present_thana = $requestedData->present_thana;
            $contactInfo->present_address_street = $requestedData->present_address_street;
            $contactInfo->present_address_village = $requestedData->present_address_village;
            $contactInfo->present_address_house_no = $requestedData->present_address_house_no;
            $contactInfo->save();
            $requestedData->status = 1;
            $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by:null;
            $requestedData->save();
            //send a mail while accept request
            return response()->json(['message' => 'accepted.'], 200);
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }

    public function familyInfoUpdateRequest(Request $request, $staff_id){
        if ($request->status=='1' || $request->status=='accepted' || $request->status=='accept'){
            return $this->familyMemberInfoRequestAccepted($request, $staff_id);
        }
        return $this->familyMemberInfoRequestRejected($request, $staff_id);

    }
    public function familyMemberInfoRequestRejected($request, $staff_id){

        $requestedData = $this->employeeFamilyMemberInfoUpdateRequest->getEmployeeFamilyMemberInfo($staff_id);
        if (empty($requestedData)) return response()->json(['errors' => 'Resource not found'], 404);
        $requestedData->status = 2;
        $request->has('rejection_reason')? $requestedData->rejection_reason =$request->rejection_reason:null;
        $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by:null;

        $requestedData->save();
        //send a mail while Reject request
        return response()->json(['message' => 'Rejected.'], 200);
    }
    public function familyMemberInfoRequestAccepted($request, $staff_id){

        $requestedData = $this->employeeFamilyMemberInfoUpdateRequest->getEmployeeFamilyMemberInfo($staff_id);
        $familyMemberInfo =  $this->employeeFamilyMemberInfo->getEmployeeInfo($staff_id);
        if (!empty($requestedData) && !empty($familyMemberInfo)){
            $familyMemberInfo->gender_id = $requestedData->gender_id;
            $familyMemberInfo->phone_no = $requestedData->phone_no;
            $familyMemberInfo->nid = $requestedData->nid;
            $familyMemberInfo->birth_certification_no = $requestedData->birth_certification_no;
            $familyMemberInfo->spouse_position = $requestedData->spouse_position;
            $familyMemberInfo->spouse_company = $requestedData->spouse_company;
            $familyMemberInfo->spouse_phone_no = $requestedData->spouse_phone_no;
            $familyMemberInfo->spouse_occupation = $requestedData->spouse_occupation;
            $familyMemberInfo->spouse_national_id = $requestedData->spouse_national_id;
            $familyMemberInfo->spouse_dob = $requestedData->spouse_dob;
            $familyMemberInfo->spouse_name = $requestedData->spouse_name;
            $familyMemberInfo->employee_mother_name = $requestedData->employee_mother_name;
            $familyMemberInfo->employee_mother_dob = $requestedData->employee_mother_dob;
            $familyMemberInfo->employee_mother_occupation_id = $requestedData->employee_mother_occupation_id;
            $familyMemberInfo->employee_mother_phone_no = $requestedData->employee_mother_phone_no;
            $familyMemberInfo->employee_mother_address = $requestedData->employee_mother_address;
            $familyMemberInfo->employee_father_name = $requestedData->employee_father_name;
            $familyMemberInfo->employee_father_dob = $requestedData->employee_father_dob;
            $familyMemberInfo->employee_father_occupation_id = $requestedData->employee_father_occupation_id;
            $familyMemberInfo->employee_father_phone_no = $requestedData->employee_father_phone_no;
            $familyMemberInfo->employee_father_address = $requestedData->employee_father_address;
            $familyMemberInfo->save();
            $requestedData->status = 1;
            $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by = $request->Accept_or_rejected_by:null;
            $requestedData->save();

            //send a mail while accept request
            return response()->json(['message' => 'accepted.'], 200);
        }
        return response()->json(['errors' => 'Resource not found'], 404);

    }

    public function employeeInfoUpdateRequest(Request $request, $staff_id){
        if ($request->status=='1' || $request->status=='accepted' || $request->status=='accept'){
            return $this->employeeInfoRequestAccepted($request, $staff_id);
        }
        return $this->employeeInfoRequestRejected($request, $staff_id);

    }

    public function employeeInfoRequestAccepted($request, $staff_id){

        $requestedData = $this->employeeInfoUpdateRequest->getEmployeeInfo($staff_id);
        $employeeInfo =  $this->employeeInfo->getEmployeeInfo($staff_id);
        if (!empty($requestedData) && !empty($employeeInfo)){
            $employeeInfo->employee_type = $requestedData->employee_type;
            $employeeInfo->designation_id = $requestedData->designation_id;
            $employeeInfo->employee_org_id = $requestedData->employee_org_id;
            $employeeInfo->access_card_no = $requestedData->access_card_no;
            $employeeInfo->org_division_id = $requestedData->org_division_id;
            $employeeInfo->org_department_id = $requestedData->org_department_id;
            $employeeInfo->location_id = $requestedData->location_id;
            $employeeInfo->subLocation_id = $requestedData->subLocation_id;
            $employeeInfo->jobLevel_id = $requestedData->jobLevel_id;
            $employeeInfo->lineManager_1st = $requestedData->lineManager_1st;
            $employeeInfo->lineManager_2nd = $requestedData->lineManager_2nd;
            $employeeInfo->shiftType_id = $requestedData->shiftType_id;
            $employeeInfo->joiningDate = $requestedData->joiningDate;
            $employeeInfo->position_id = $requestedData->position_id;
            $employeeInfo->employment_date = $requestedData->employment_date;
            $employeeInfo->employment_end_date = $requestedData->employment_end_date;
            $employeeInfo->contract_type_id = $requestedData->contract_type_id;
            $employeeInfo->contract_duration = $requestedData->contract_duration;
            $employeeInfo->contract_end_date = $requestedData->contract_end_date;
            $employeeInfo->bank_id = $requestedData->bank_id;
            $employeeInfo->bank_account_no = $requestedData->bank_account_no;
            $employeeInfo->bank_account_name = $requestedData->bank_account_name;
            $employeeInfo->tax_responsible_id = $requestedData->tax_responsible_id;
            $employeeInfo->payment_type_id = $requestedData->payment_type_id;
            $employeeInfo->working_day_id = $requestedData->working_day_id;
            $employeeInfo->employee_status_id = $requestedData->employee_status_id;
            $employeeInfo->exit_date = $requestedData->exit_date;
            $employeeInfo->exit_reason_id = $requestedData->exit_reason_id;
            $employeeInfo->save();
            $requestedData->status = 1;
            if ($request->has('Accept_or_rejected_by')) {
                $requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by;
            }
            $requestedData->save();
            //send a mail while accept request
            return response()->json(['message' => 'accepted.'], 200);
        }
        return response()->json(['errors' => 'Resource not found'], 404);
    }
    public function employeeInfoRequestRejected($request, $staff_id){
        $requestedData = $this->employeeInfoUpdateRequest->getEmployeeInfo($staff_id);
        if (empty($requestedData)) return response()->json(['errors' => 'Resource not found'], 404);
        $requestedData->status = 2;
        $request->has('rejection_reason')? $requestedData->rejection_reason =$request->rejection_reason:null;
        $request->has('Accept_or_rejected_by')?$requestedData->Accept_or_rejected_by =$request->Accept_or_rejected_by:null;
        $requestedData->save();
        //send a mail while Reject request
        return response()->json(['message' => 'Rejected.'], 200);
    }



}
