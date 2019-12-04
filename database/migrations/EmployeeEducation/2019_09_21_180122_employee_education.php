<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeeEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeeducations', function (Blueprint $table) {
            $table->string('education_level')->nullable();
            $table->string('university_name');
            $table->bigInteger('country_code');
            $table->date('graduation_year');
            $table->string('major');
            $table->string('gpa');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeeeducations');
    }
}
