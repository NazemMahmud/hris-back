<?php


namespace App\GenericSolution\GenericModels\Import\Employee;
use App\Enums\SetupEnums\CountryEnum;
use App\Enums\SetupEnums\DistrictEnum;
use App\Enums\SetupEnums\EmployeeTypeEnum;
use App\Enums\SetupEnums\GenderEnum;
use App\Enums\SetupEnums\LanguageEnum;
use App\Enums\SetupEnums\MaritalStatusEnum;
use App\Enums\SetupEnums\NationalIdEnum;
use App\Enums\SetupEnums\OragnizationEnum;
use App\Enums\SetupEnums\RandomValueEnum;
use App\Models\Employee\BasicInfo;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeInfo;
use App\Models\Setup\Band;
use App\Models\Setup\EmployeeDivision;
use App\Models\Setup\EmployeeUnit;
use App\Models\Setup\Gender;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\GenericSolution\GenericModels\ExportUtility\ImportUtility;
use App\Models\Designation\DesignationModel;
use App\Models\Setup\EmployeeDepartment;
use App\Models\Setup\EmployeeDivision as AppEmployeeDivision;
use App\Models\Setup\Position;
use Illuminate\Support\Facades\DB;

class EmployeeImport implements ToCollection, WithHeadingRow
{

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
       
        //DB::beginTransaction();
        foreach ($rows as $row)
        {
            $employee = new Employee();
            $employee->employeeName = $row['employee_name'];
            $employee->public_employee_id = $row['employee_id'];
            $employee->save();
            $staff_id = $employee->id;

            if(isset($row['designation']) and ImportUtility::IsNotExist('designation', 'name', $row['designation'])) {
                $designation = DesignationModel::create([
                    'name' => $row['designation']
                ]);
            } else {
                $designation = ImportUtility::getEntity('designation', 'name', $row['designation']);
            }

            if(isset($row['position_text']) and ImportUtility::IsNotExist('positions', 'name', $row['position_text'])) {
                $postion = new Position();
                $postion->name = $row['position_text'] ? $row['position_text'] : 'none';
                $postion->code = $row['position_id'] ? $row['position_id'] : 0;
                $postion->save();
            } else {
                $postion = ImportUtility::getEntity('positions', 'name', $row['position_text']);
            }


            if(isset($row['division']) and ImportUtility::IsNotExist('employee_divisions', 'name', $row['division'])) {
                $division = new EmployeeDivision();
                $division->name = $row['division'];
                $division->save();
            } else {
                $division = ImportUtility::getEntity('employee_divisions', 'name', $row['division']);
            }

            if(isset($row['department']) and ImportUtility::IsNotExist('employee_departments', 'name', $row['department'])) {
               $department = new EmployeeDepartment();
                $department->name = $row['department'] ? $row['department']: 'none';
                $department->division_id =  $division->id;
                $department->save();
            } else {
                $department = ImportUtility::getEntity('employee_departments', 'name', $row['department']);
            }

            if(isset($row['unit']) and ImportUtility::IsNotExist('employee_units', 'name', $row['unit'])) {
                $unit = new EmployeeUnit();
                $unit->name = $row['unit'] ? $row['unit']: 'none';
                $unit->division_id = $division->id;
                $unit->department_id = $department->id;
                $unit->save();
            } else {
                $unit = ImportUtility::getEntity('employee_units', 'name', $row['unit']);
            }

            if(isset($row['employee_band']) and ImportUtility::IsNotExist('bands', 'name', $row['employee_band'])) {
                $band = new Band();
                $band->name = $row['employee_band'];
                $band->save();
            } else {
                $band = ImportUtility::getEntity('bands', 'name', $row['employee_band']);
            }

            if(isset($row['gender']) and ImportUtility::IsNotExist('genders', 'name', $row['gender'])) {
                $gender = new Gender();
                $gender->name = $row['gender'] ? $row['gender']: 'Male';
                $gender->save();
            } else {
                $gender = ImportUtility::getEntity('genders', 'name', $row['gender']);
            }

            //Basic information store for employee
            $basic_information = new BasicInfo();
            $basic_information->familyName = $row['employee_name'];
            $basic_information->givenName = $row['employee_name'];
            $basic_information->familyNameBangla = $row['employee_name'];
            $basic_information->givenNameBangla = $row['employee_name'];
            $basic_information->staff_id = $staff_id;
            $basic_information->genderId = isset($gender->id) ? $gender->id : GenderEnum::Male()->getValue();
            $basic_information->maritalStatusId = MaritalStatusEnum::Single()->getValue();
            $basic_information->languageId = LanguageEnum::English()->getValue();
            $basic_information->nationalIdNumber = NationalIdEnum::DefaultNationalId()->getValue();
            $basic_information->countryId = CountryEnum::Bangladesh()->getValue();
            $basic_information->divisionId = $division->id;
            $basic_information->districtId = DistrictEnum::Dhaka()->getValue();
            $basic_information->dateofBirth = Carbon::now();
            $basic_information->maritalDate = Carbon::now();
            $basic_information->save();

            $first_line_manager = ImportUtility::getEntity('employees', 'public_employee_id', $row['semployee_id']);
            $first_line_manager = $first_line_manager ? $first_line_manager->id: RandomValueEnum::Random()->getValue();
            $secound_line_manager = ImportUtility::getEntity('employees', 'public_employee_id', $row['2nd_lvl_supervisor_id']);
            $secound_line_manager = $secound_line_manager ? $secound_line_manager->id : RandomValueEnum::Random()->getValue();
            $third_line_manager = ImportUtility::getEntity('employees', 'public_employee_id', $row['3rd_lvl_supervisor_id']);
            $third_line_manager = $third_line_manager ? $third_line_manager->id : RandomValueEnum::Random()->getValue();

            //Employee employee_info data store
            $employee_info = new EmployeeInfo();
            $employee_info->staff_id = $staff_id;
            $employee_info->employee_type = EmployeeTypeEnum::FullTime()->getValue();
            $employee_info->employee_org_id = OragnizationEnum::Robi()->getValue();
            $employee_info->access_card_no = RandomValueEnum::Random()->getValue();
            $employee_info->org_division_id = $division->id;
            $employee_info->org_department_id = $department->id;
            $employee_info->designation_id = $designation->id;
            $employee_info->org_unit_id = $unit->id;
            $employee_info->location_id = RandomValueEnum::Random()->getValue();
            $employee_info->subLocation_id = RandomValueEnum::Random()->getValue();
            $employee_info->jobLevel_id = RandomValueEnum::Random()->getValue();
            $employee_info->lineManager_1st = $first_line_manager;
            $employee_info->lineManager_2nd = $secound_line_manager;
            $employee_info->division_head =  $third_line_manager;
            $employee_info->hrbp = RandomValueEnum::Random()->getValue();
            $employee_info->shiftType_id = RandomValueEnum::Random()->getValue();
            $employee_info->joiningDate = Carbon::now();
            $employee_info->position_id = $postion->id;
            // $employee_info->contactType = RandomValueEnum::Random()->getValue();
            //$employee_info->taxResponsible = RandomValueEnum::Random()->getValue();
            // $employee_info->paymentType_id = RandomValueEnum::Random()->getValue();
            //$employee_info->workingDays = RandomValueEnum::Random()->getValue();
            //$employee_info->tin = RandomValueEnum::Random()->getValue();
            $employee_info->save();

        }
        //DB::commit();
    }
}
