<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Travelallowances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tallowances_setup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('band');
            $table->bigInteger('total');
            $table->bigInteger('breakfast');
            $table->bigInteger('lunch');
            $table->bigInteger('dinner');
            $table->bigInteger('incidental');
            $table->boolean('isActive')->default(1);
            Fields::MakeCommonField($table);
        });

        Schema::create('travel_allowances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('travel_id');
            $table->bigInteger('breakfast_total');
            $table->bigInteger('lunch_total');
            $table->bigInteger('dinner_total');
            $table->bigInteger('incidental_total');
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
        Schema::dropIfExists('tallowances_setup');
        Schema::dropIfExists('travel_allowances');
    }
}
