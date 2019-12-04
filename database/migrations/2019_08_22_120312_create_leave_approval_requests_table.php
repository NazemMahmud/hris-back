<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApprovalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_approval_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('leaveRequestId');
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
        Schema::dropIfExists('leave_approval_requests');
    }
}
