<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_balance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id');
            $table->string('name');
            $table->bigInteger('start_time')->unsigned()->nullable();
            $table->bigInteger('end_time')->unsigned()->nullable();
            $table->integer('annual_leave')->unsigned()->nullable();
            $table->integer('carry_forward')->unsigned()->nullable();
            $table->integer('adjustment')->unsigned()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_balance');
    }
}
