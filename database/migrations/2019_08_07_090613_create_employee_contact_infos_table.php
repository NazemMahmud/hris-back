<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeContactInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contact_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('office_phone_no');
            $table->unsignedBigInteger('home_phone_no');
            $table->unsignedBigInteger('extension_no');
            $table->string('personal_email');
            $table->string('company_email');
            $table->string('relation_name');
            $table->string('second_contact_name');
            $table->unsignedBigInteger('phone_no_01');
            $table->unsignedBigInteger('phone_no_2');
            $table->string('permanent_address');
            $table->string('permanent_country');
            $table->string('permanent_division');
            $table->string('permanent_district');
            $table->string('permanent_thana');
            $table->string('permanent_city');
            $table->string('present_address');
            $table->string('present_country');
            $table->string('present_division');
            $table->string('present_district');
            $table->string('present_thana');
            $table->string('present_city');
            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(1);
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
        Schema::dropIfExists('employee_contact_infos');
    }
}
