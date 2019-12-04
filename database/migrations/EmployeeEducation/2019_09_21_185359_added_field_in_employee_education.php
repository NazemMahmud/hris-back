<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedFieldInEmployeeEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeeeducations', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->bigInteger('employee_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_education', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->bigInteger('employee_id')->after('id');
        });
    }
}
