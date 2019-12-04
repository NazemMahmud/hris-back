<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmployeeBasicInfoTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->renameColumn('picName', 'employeeImageUrl')->nullable();
            $table->renameColumn('nationalityId', 'nationalIdNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_basic_info', function (Blueprint $table) {
            $table->renameColumn('employeeImageUrl', 'picName')->nullable();
            $table->renameColumn('nationalIdNumber', 'nationalityId')->nullable();
        });
    }
}
