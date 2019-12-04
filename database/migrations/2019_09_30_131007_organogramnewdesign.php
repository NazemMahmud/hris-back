<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Organogramnewdesign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->bigInteger('public_employee_id')->after('employeeName')->nullable();
        });

        Schema::create('designation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(1);
            $table->timestamps();
        });

        Schema::table('employee_info', function (Blueprint $table) {
            $table->bigInteger('designation_id')->after('employee_type')->nullable();
            $table->bigInteger('division_head')->after('lineManager_2nd')->nullable();
            
        });

        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->string('employee_email')->after('staff_id')->nullable();
            $table->string('e_office_phone')->after('employee_email')->nullable();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('Salary');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('public_employee_id');
        });

        Schema::table('designation', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('isActive');
            $table->dropColumn('isDefault');
        });

        Schema::table('employee_info', function (Blueprint $table) {
            $table->dropColumn('designation_id');
            $table->dropColumn('division_head');
        });

        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->dropColumn('employee_email');
            $table->dropColumn('employee_office_phone');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->string('Salary');
        });
    }
}
