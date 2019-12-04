<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManualAttendanceApprovalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_attendance_approval_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('manualAttendanceId');
            $table->bigInteger('userLevelId');
            $table->string('status');
            $table->integer('next_level')->default(1)->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manual_attendance_approval_requests');
    }
}
