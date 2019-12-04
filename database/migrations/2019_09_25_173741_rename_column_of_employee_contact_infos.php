<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnOfEmployeeContactInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_contact_infos', function (Blueprint $table) {

            $table->renameColumn('permanent_street', 'permanent_address_street')->nullable();
            $table->renameColumn('permanent_house_no', 'permanent_address_house_no')->nullable();
            $table->renameColumn('permanent_village', 'permanent_address_village')->nullable();
            $table->renameColumn('permanent_district_id', 'permanent_address_district_id')->nullable();
            $table->renameColumn('permanent_division', 'permanent_address_division_id')->nullable();
            $table->renameColumn('permanent_city_id', 'permanent_address_city_id')->nullable();
            $table->renameColumn('permanent_country_id', 'permanent_address_country_id')->nullable();


            $table->renameColumn('present_house_no', 'present_address_house_no')->nullable();
            $table->renameColumn('present_street', 'present_address_street')->nullable();
            $table->renameColumn('present_village', 'present_address_village')->nullable();
            $table->renameColumn('present_division', 'present_address_division')->nullable();
            $table->renameColumn('present_district_id', 'present_address_district_id')->nullable();
            $table->renameColumn('present_city_id', 'present_address_city_id')->nullable();
            $table->renameColumn('present_country_id', 'present_address_country_id')->nullable();




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
