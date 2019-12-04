<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnEmployeeFamilyMemberInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_family_member_infos', function (Blueprint $table) {
            $table->dropColumn('full_name')->nullable();
            $table->dropColumn('full_name_bangla')->nullable();
            $table->dropColumn('address')->nullable();
            $table->dropColumn('dob')->nullable();
            $table->string('gender_id')->default(null)->change()->nullable();
            $table->string('phone_no')->default(null)->change()->nullable();
            $table->string('nid')->default(null)->change()->nullable();
            $table->string('birth_certification_no')->default(null)->change()->nullable();
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
