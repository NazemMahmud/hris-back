<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\GenericSolution\GenericModelFields\Fields;

class CreateEmployeeContactInfoUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contact_info_update_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('contact_info_id');
            $table->string('home_phone_no')->nullable();
            $table->string('extension_no')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('company_email')->nullable();
            $table->string('second_contact_name')->nullable();
            $table->string('phone_no_01')->nullable();
            $table->string('phone_no_2')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('permanent_address_country_id')->nullable();
            $table->string('permanent_address_division_id')->nullable();
            $table->string('permanent_address_district_id')->nullable();
            $table->string('permanent_address_thana')->nullable();
            $table->string('permanent_address_city_id')->nullable();
            $table->string('present_address')->nullable();
            $table->string('present_address_country_id')->nullable();
            $table->string('present_address_division_id')->nullable();
            $table->string('present_address_district_id')->nullable();
            $table->string('present_address_thana')->nullable();
            $table->string('present_address_city_id')->nullable();

            $table->string('office_address_no_1')->nullable();
            $table->string('office_address_no_2')->nullable();
            $table->string('office_address_no_3')->nullable();
            $table->string('relationship')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_no_1')->nullable();
            $table->string('emergency_contact_no_2')->nullable();

            $table->string('office_phone_no_1')->nullable();
            $table->string('office_phone_no_2')->nullable();
            $table->string('office_phone_no_3')->nullable();

            $table->string('permanent_address_street')->nullable();
            $table->string('permanent_address_village')->nullable();
            $table->string('permanent_address_house_no')->nullable();
            $table->string('permanent_thana')->nullable();

            $table->string('present_thana')->nullable();
            $table->string('present_address_street')->nullable();
            $table->string('present_address_village')->nullable();
            $table->string('present_address_house_no')->nullable();

            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('Accept_or_rejected_by')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(1);
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
        Schema::dropIfExists('employee_contact_info_update_requests');
    }
}
