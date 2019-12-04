<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveTypeAddedInAllocateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocated_leave_types', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_type_id')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allocated_leave_types', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_type_id')->after('name');
        });
    }
}
