<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('employee_type');
            $table->unsignedBigInteger('employee_org_id')->nullable();
            $table->unsignedBigInteger('access_card_no')->nullable();
            $table->unsignedBigInteger('org_division_id');
            $table->unsignedBigInteger('org_department_id');
            $table->unsignedBigInteger('org_unit_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('subLocation_id');
            $table->unsignedBigInteger('jobLevel_id');
            $table->unsignedBigInteger('lineManager_1st');
            $table->unsignedBigInteger('lineManager_2nd');
            $table->unsignedBigInteger('hrbp');
            $table->unsignedBigInteger('shiftType_id');
            $table->dateTime('joiningDate');
            $table->unsignedBigInteger('position_id');
            $table->string('contactType');
            $table->string('taxResponsible');
            $table->unsignedBigInteger('paymentType_id');
            $table->string('workingDays');
            $table->string('tin');
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
        Schema::dropIfExists('employee_info');
    }
}
