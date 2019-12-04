<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalClaimRequestsTable extends Migration
{

    public function up()
    {
        Schema::create('medical_claim_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_name');
            $table->string('organization_name');
            $table->string('designation');
            $table->string('patient_name');
            $table->integer('relationship_id');
            $table->integer('hospital_id');
            $table->string('mobile_number');
            $table->string('cause_for_admission');
            $table->dateTime('admission_date');
            $table->boolean('isActive')->default(0);
            $table->boolean('isDefault')->default(0);
            Fields::AddCommonField($table);
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
        Schema::dropIfExists('medical_claim_requests');
    }
}
