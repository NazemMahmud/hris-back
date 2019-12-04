<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnEmployeeInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_info', function (Blueprint $table) {
            $table->dropColumn('paymentType_id')->nullable();
            $table->dropColumn('taxResponsible')->nullable();
            $table->dropColumn('tin')->nullable();
            $table->dropColumn('workingDays')->nullable();
            $table->dropColumn('contactType')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_info', function (Blueprint $table) {
            //
        });
    }
}
