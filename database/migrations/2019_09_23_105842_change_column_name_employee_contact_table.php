<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameEmployeeContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_contact_infos', function (Blueprint $table) {
            $table->renameColumn('office_address_no_1', 'office_phone_no_1')->nullable();
            $table->renameColumn('office_address_no_2', 'office_phone_no_2')->nullable();
            $table->renameColumn('office_address_no_3', 'office_phone_no_3')->nullable();
            $table->dropColumn('office_phone_no')->nullable();
            $table->dropColumn('relation_name')->nullable();
            
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
