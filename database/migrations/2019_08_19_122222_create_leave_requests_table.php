<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('leave_type_id');
            $table->bigInteger('staff_id');
            $table->DateTime('date_From');
            $table->DateTime('date_To');
            $table->bigInteger('time_From')->unsigned()->nullable();
            $table->bigInteger('time_To')->unsigned()->nullable();
            $table->bigInteger('totalDurationDays')->default(0);
            $table->bigInteger('delegatee')->nullable();
            $table->boolean('isBridge')->default(0);
            $table->string('reason');
            $table->integer('requestStatus')->nullable()->default(0);
            $table->string('statusComment')->nullable();
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
        Schema::dropIfExists('leave_requests');
    }
}
