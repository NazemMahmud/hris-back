<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameEmployeeFamilyMemberInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_family_member_infos', function (Blueprint $table) {
            $table->string('full_name_bangla')->default(null)->change()->nullable();
            $table->renameColumn('DOB', 'dob')->nullable();
            $table->renameColumn('NID', 'nid')->nullable();
            $table->renameColumn('Gender', 'gender_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_family_member_infos', function (Blueprint $table) {
            //
        });
    }
}
