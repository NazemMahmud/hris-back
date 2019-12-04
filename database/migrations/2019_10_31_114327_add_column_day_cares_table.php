<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDayCaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_cares', function (Blueprint $table) {
            $table->text('rejection_reason')->after('status')->nullable();
            $table->bigInteger('staff_id')->after('children_id')->nullable();
            $table->bigInteger('accept_or_rejected_by')->after('status')->nullable();
            Schema::dropIfExists('employee_childens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_cares', function (Blueprint $table) {
            //
        });
    }
}
