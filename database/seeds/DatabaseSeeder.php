<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(AssignRoleToAdmin::class);
        $this->call(LeaveTypesTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(ShiftTypeSeeder::class);
        $this->call(EmployeeBasicInfoTableSeeder::class);
        $this->call(EmployeeContactInfTableSeeder::class);
        $this->call(BandTableSeeder::class);
        $this->call(BloodGroupTableSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ContractTypeTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(EmployeeDivisionTableSeeder::class);
        $this->call(EmployeeDepartmentTableSeeder::class);
        $this->call(EmployeeUnitTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(EducationLevelTableSeeder::class);
        $this->call(EmployeeLevelTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(DivisionTableSeeder::class);
        $this->call(EmployeeExitReasonTableSeeder::class);
        $this->call(EmployeeJoblevelTableSeeder::class);
        $this->call(EmployeeLocationTableSeeder::class);
        $this->call(AttendenceStatus::class);
        $this->call(TreatmentModeTableSeeder::class);
        $this->call(RelationshipTableSeeder::class);
    }
}
