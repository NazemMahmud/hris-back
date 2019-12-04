<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnStructureEmployeeContactInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_contact_infos', function (Blueprint $table) {
            $table->string('home_phone_no')->default(null)->change()->nullable();
            $table->string('extension_no')->default(null)->change()->nullable();
            $table->string('personal_email')->default(null)->change()->nullable();
            $table->string('second_contact_name')->default(null)->change()->nullable();
            $table->string('phone_no_01')->default(null)->change()->nullable();
            $table->string('phone_no_2')->default(null)->change()->nullable();
            $table->string('permanent_address')->default(null)->change()->nullable();
            $table->string('permanent_country_id')->default(null)->change()->nullable();
            $table->string('permanent_division')->default(null)->change()->nullable();
            $table->string('permanent_district_id')->default(null)->change()->nullable();
            $table->string('permanent_thana')->default(null)->change()->nullable();
            $table->string('permanent_city_id')->default(null)->change()->nullable();
            $table->string('present_address')->default(null)->change()->nullable();
            $table->string('present_country_id')->default(null)->change()->nullable();
            $table->string('present_division')->default(null)->change()->nullable();
            $table->string('present_district_id')->default(null)->change()->nullable();
            $table->string('present_city_id')->default(null)->change()->nullable();
            $table->string('present_thana')->default(null)->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_contact_infos', function (Blueprint $table) {
            //
        });
    }
}
