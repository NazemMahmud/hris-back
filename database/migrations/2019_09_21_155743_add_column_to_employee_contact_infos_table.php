<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEmployeeContactInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_contact_infos', function (Blueprint $table) {
            $table->string('office_address_no_1')->nullable();
            $table->string('office_address_no_2')->nullable();
            $table->string('office_address_no_3')->nullable();
            $table->string('relationship')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_no_1')->nullable();
            $table->string('emergency_contact_no_2')->nullable();
            
            $table->renameColumn('permanent_country', 'permanent_country_id')->nullable();
            $table->renameColumn('permanent_city', 'permanent_city_id')->nullable();
            $table->renameColumn('permanent_district', 'permanent_district_id')->nullable();
            $table->string('permanent_street')->nullable();
            $table->string('permanent_village')->nullable();
            $table->string('permanent_house_no')->nullable();

            $table->renameColumn('present_country', 'present_country_id')->nullable();
            $table->renameColumn('present_city', 'present_city_id')->nullable();
            $table->renameColumn('present_district', 'present_district_id')->nullable();
            $table->string('present_street')->nullable();
            $table->string('present_village')->nullable();
            $table->string('present_house_no')->nullable();


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
