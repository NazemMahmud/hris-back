<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\GenericSolution\GenericModelFields\Fields;
class CreateEmployeeFamilyMemberInfoUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_family_member_info_update_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('family_member_info_id');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('phone_no')->nullable();
            $table->string('nid')->nullable();
            $table->string('birth_certification_no')->nullable();
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
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('Accept_or_rejected_by')->nullable();
            $table->text('rejection_reason')->nullable();
            Fields::AddCommonField($table);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_family_member_info_update_requests');
    }
}
