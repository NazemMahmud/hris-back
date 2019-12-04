<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TravelManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            Fields::MakeCommonField($table);
        });

        Schema::create('trip_purpose', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            Fields::MakeCommonField($table);
        });

        Schema::create('trip_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            Fields::MakeCommonField($table);
        });

        Schema::create('modeof_travel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            Fields::MakeCommonField($table);
        });

        Schema::create('travels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staff_id');
            $table->dateTime('start_dtime');
            $table->dateTime('end_dtime');
            $table->bigInteger('trip_id');
            $table->bigInteger('purpose_id');
            $table->bigInteger('reason_id');
            $table->bigInteger('mode_id');
            $table->bigInteger('country_id');
            $table->bigInteger('estimate_cost')->nullable();
            $table->text('destination')->nullable();
            $table->integer('status');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('trip_types');
        Schema::dropIfExists('trip_purpose');
        Schema::dropIfExists('trip_reasons');
        Schema::dropIfExists('modeof_travel');
        Schema::dropIfExists('travels');
    }
}
