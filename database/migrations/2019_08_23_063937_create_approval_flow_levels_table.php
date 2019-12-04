<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalFlowLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_flow_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('approval_flow_type_id');
            $table->string('level')->nullable();
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
        Schema::dropIfExists('approval_flow_levels');
    }
}
