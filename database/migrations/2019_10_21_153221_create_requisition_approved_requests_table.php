<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionApprovedRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_approved_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('requisition_request_id')->nullable();
            $table->integer('userLevel_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('next_level')->nullable();
            $table->integer('isActive')->nullable();
            $table->integer('isDefault')->nullable();


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
        Schema::dropIfExists('requisition_approved_requests');
    }
}
