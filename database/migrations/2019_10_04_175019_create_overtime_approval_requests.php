<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeApprovalRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_approval_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('overtime_request_id');
            $table->bigInteger('requested_user_id');
            $table->bigInteger('user_level_id');
            $table->string('status');
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('overtime_approval_requests');
    }
}
