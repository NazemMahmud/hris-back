<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveBalanceTypeColummnNameChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_balance_type', function (Blueprint $table) {
            $table->renameColumn('leave_type_id', 'allocated_leave_types_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_balance_type', function (Blueprint $table) {
            $table->renameColumn('leave_type_id', 'allocated_leave_types_id');
        });
    }
}
