<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Travelrequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_approval_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('travel_id');
            $table->bigInteger('level_id');
            $table->bigInteger('next_level')->nullable();
            $table->bigInteger('approved_by');
            $table->char('status', 30);
            Fields::MakeCommonField($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_approval_request');
    }
}
