<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEmployeeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_info', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('employment_date')->nullable();
            $table->date('employment_end_date')->nullable();
            $table->unsignedBigInteger('contract_type_id')->nullable();
            $table->string('contract_duration')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->unsignedBigInteger('tax_responsible_id')->nullable();
            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->unsignedBigInteger('working_day_id')->nullable();
            $table->unsignedBigInteger('employee_status_id')->nullable();
            $table->date('exit_date')->nullable();
            $table->unsignedBigInteger('exit_reason_id')->nullable();
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
