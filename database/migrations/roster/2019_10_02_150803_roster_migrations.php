<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RosterMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->softDeletes('softDelete');
            Fields::MakeCommonField($table);
        });

        Schema::create('employee_rosters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('roster_id');
            $table->bigInteger('staff_id');
            $table->dateTime('start_dtime');
            $table->dateTime('end_dtime');
            $table->softDeletes('softDelete');
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
        Schema::dropIfExists('rosters');
        Schema::dropIfExists('employee_rosters');
    }
}
