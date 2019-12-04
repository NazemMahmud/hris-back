<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\GenericSolution\GenericModelFields\Fields;

class CreateEmployeeInfoUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_info_update_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('employee_info_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();;
            $table->unsignedBigInteger('employee_type')->nullable();;
            $table->unsignedBigInteger('designation_id')->nullable();;
            $table->unsignedBigInteger('employee_org_id')->nullable();
            $table->unsignedBigInteger('access_card_no')->nullable();
            $table->unsignedBigInteger('org_division_id')->nullable();;
            $table->unsignedBigInteger('org_department_id')->nullable();;
            $table->unsignedBigInteger('org_unit_id')->nullable();;
            $table->unsignedBigInteger('location_id')->nullable();;
            $table->unsignedBigInteger('subLocation_id')->nullable();;
            $table->unsignedBigInteger('jobLevel_id')->nullable();;
            $table->unsignedBigInteger('lineManager_1st')->nullable();;
            $table->unsignedBigInteger('lineManager_2nd')->nullable();;
            $table->unsignedBigInteger('hrbp')->nullable();;
            $table->unsignedBigInteger('shiftType_id')->nullable();;
            $table->dateTime('joiningDate')->nullable();;
            $table->unsignedBigInteger('position_id')->nullable();;
            $table->string('contactType')->nullable();;
            $table->string('taxResponsible')->nullable();;
            $table->unsignedBigInteger('paymentType_id')->nullable();;
            $table->string('workingDays')->nullable();;
            $table->string('tin')->nullable();;

            $table->date('employment_date')->nullable();
            $table->date('employment_end_date')->nullable();
            $table->unsignedBigInteger('contract_type_id')->nullable();
            $table->string('contract_duration')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->unsignedBigInteger('tax_responsible_id')->nullable();
            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->unsignedBigInteger('working_day_id')->nullable();
            $table->unsignedBigInteger('employee_status_id')->nullable();
            $table->date('exit_date')->nullable();
            $table->unsignedBigInteger('exit_reason_id')->nullable();
            $table->date('probation_end_date')->nullable();

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
        Schema::dropIfExists('employee_info_update_requests');
    }
}
