<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSoftDeleteColumnFromTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(' employee_children_infos', function (Blueprint $table) {
            $table->dropColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_contracts', function (Blueprint $table) { // kono softDelete name column nai
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_departments', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_divisions', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_exit_reasons', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_job_levels', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_levels', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_locations', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_statuses', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_sublocations', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_types', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('employee_units', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('genders', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('group_permissions', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('leave_types', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('nationalities', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('occupations', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('organization_bands', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('organization_departments', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('organization_divisions', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('organization_units', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('payment_types', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('roster_attendance', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
        Schema::table('tallowances_setup', function (Blueprint $table) {
            $table->renameColumn('softDelete', 'deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
}
