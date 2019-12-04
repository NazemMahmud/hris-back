<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnBasicInfoUpdateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_info_update_requests', function (Blueprint $table) {
            $table->bigInteger('employee_email')->after('staff_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basic_info_update_requests', function (Blueprint $table) {
            $table->dropColumn('employee_email');
        });
    }
}
