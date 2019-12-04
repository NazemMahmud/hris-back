<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeBasicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_basic_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->string('familyName');
            $table->string('givenName');
            $table->string('familyNameBangla');
            $table->string('givenNameBangla');
            $table->unsignedBigInteger('genderId');
            $table->unsignedBigInteger('maritalStatusId');
            $table->dateTime('dateofBirth');
            $table->unsignedBigInteger('languageId');
            $table->unsignedBigInteger('nationalityid');
            $table->unsignedBigInteger('countryId');
            $table->unsignedBigInteger('divisionId');
            $table->unsignedBigInteger('districtId');
            $table->dateTime('maritalDate')->nullable();
            $table->string('picName')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(0);
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
        Schema::dropIfExists('employee_basic_info');
    }
}
