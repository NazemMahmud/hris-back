<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicInfoUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_info_update_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('basic_info_id')->nullable();
            $table->string('familyName')->nullable();
            $table->string('familyNameBangla')->nullable();
            $table->string('givenName')->nullable();
            $table->string('givenNameBangla')->nullable();
            $table->unsignedBigInteger('genderId')->nullable();
            $table->unsignedBigInteger('maritalStatusId')->nullable();
            $table->dateTime('dateOfBirth')->nullable();
            $table->unsignedBigInteger('languageId')->nullable();
            $table->unsignedBigInteger('nationalityId')->nullable();
            $table->unsignedBigInteger('nationalIdNumber')->nullable();
            $table->date('nationalIdIssueDate')->nullable();
            $table->date('nationalIdExpireDate')->nullable();
            $table->unsignedBigInteger('countryId')->nullable();
            $table->unsignedBigInteger('divisionId')->nullable();
            $table->unsignedBigInteger('districtId')->nullable();
            $table->dateTime('maritalDate')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('Accept_or_rejected_by')->nullable();
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
        Schema::dropIfExists('basic_info_update_requests');
    }
}
