<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEmployeeFamilyMemberInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_family_member_infos', function (Blueprint $table) {
            $table->string('spouse_position')->nullable();
            $table->string('spouse_company')->nullable();
            $table->string('spouse_phone_no')->nullable();
            $table->string('spouse_occupation')->nullable();
            $table->string('spouse_national_id')->nullable();
            $table->date('spouse_dob')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('employee_mother_name')->nullable();
            $table->date('employee_mother_dob')->nullable();
            $table->unsignedBigInteger('employee_mother_occupation_id')->nullable();
            $table->string('employee_mother_phone_no')->nullable();
            $table->string('employee_mother_address')->nullable();
            $table->string('employee_father_name')->nullable();
            $table->date('employee_father_dob')->nullable();
            $table->unsignedBigInteger('employee_father_occupation_id')->nullable();
            $table->string('employee_father_phone_no')->nullable();
            $table->string('employee_father_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_family_member_infos', function (Blueprint $table) {
            //
        });
    }
}
