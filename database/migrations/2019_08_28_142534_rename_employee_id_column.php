<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmployeeIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->renameColumn('employee_id', 'staff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('employee_basic_info', function (Blueprint $table) {
        //     $table->renameColumn('staff_id', 'employee_id');
        // });
    }
}
