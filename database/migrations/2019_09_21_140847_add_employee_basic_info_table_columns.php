<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeBasicInfoTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->dateTime('nationalIdIssueDate');
            $table->dateTime('nationalIdExpireDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->dropColumn('nationalIdExpireDate');
            $table->dropColumn('nationalIdIssueDate');
        });
    }
}
