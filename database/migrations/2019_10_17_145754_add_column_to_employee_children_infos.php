<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEmployeeChildrenInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_children_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->after('name')->nullable();
            $table->date('dob')->after('place_of_birth')->nullable();
            $table->unsignedBigInteger('is_deleted')->after('isDefault')->nullable();
            $table->unsignedBigInteger('status')->after('isActive')->nullable()->default(0);
            $table->dropColumn('date_From');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_children_infos', function (Blueprint $table) {
            //
        });
    }
}
