<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\GenericSolution\GenericModelFields\Fields;

class CreateSoftDeleteAddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('bands', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('blood_groups', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('branches', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('cities', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('contract_durations', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('contract_types', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('countries', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('designation', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('districts', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });

        Schema::table('divisions', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('education_levels', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_childens', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_contracts', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_departments', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_divisions', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_exit_reasons', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_job_levels', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_levels', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_locations', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_statuses', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_sublocations', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_types', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('employee_units', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('genders', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('groups', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('group_permissions', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('languages', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('leave_types', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('marital_statuses', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('nationalities', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('occupations', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('organization_bands', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('organization_departments', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('organization_divisions', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('organization_units', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('pages', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('payment_types', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('positions', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('relation_types', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('roles', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('tax_responsibles', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
        Schema::table('working_days', function (Blueprint $table) {
            Fields::AddCommonField($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
        Schema::dropIfExists('bands');
        Schema::dropIfExists('blood_groups');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('contract_durations');
        Schema::dropIfExists('contract_type');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('designation');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('divisions');
        Schema::dropIfExists('education_levels');
        Schema::dropIfExists('employee_childens');
        Schema::dropIfExists('employee_contracts');
        Schema::dropIfExists('employee_departments');
        Schema::dropIfExists('employee_divisions');
        Schema::dropIfExists('employee_exit_reasons');
        Schema::dropIfExists('employee_job_levels');
        Schema::dropIfExists('employee_levels');
        Schema::dropIfExists('employee_locations');
        Schema::dropIfExists('employee_statuses');
        Schema::dropIfExists('employee_sublocations');
        Schema::dropIfExists('employee_types');
        Schema::dropIfExists('employee_units');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_permissions');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('marital_statuses');
        Schema::dropIfExists('nationalities');
        Schema::dropIfExists('occupations');
        Schema::dropIfExists('organization_bands');
        Schema::dropIfExists('organization_departments');
        Schema::dropIfExists('organization_divisions');
        Schema::dropIfExists('organization_units');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('payment_types');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('relation_types');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('tax_responsibles');
        Schema::dropIfExists('working_days');
    }
}
