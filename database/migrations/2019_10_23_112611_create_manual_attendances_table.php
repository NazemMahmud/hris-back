<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManualAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staff_id');
            $table->time('in_time');
            $table->time('out_time');
            $table->dateTime('date');
            $table->string('reason');
            $table->integer('status')->default(0)->nullable();
            $table->timestamps();
            Fields::AddCommonField($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manual_attendances');
    }
}
