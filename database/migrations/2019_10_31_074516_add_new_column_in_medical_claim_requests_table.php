<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnInMedicalClaimRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_claim_requests', function (Blueprint $table) {
            $table->integer('status')->default(0);
            $table->string('nature_of_illness');
            $table->string('hospital_address');
            $table->string('name_of_doctor');
            $table->boolean('prescribed_by_doctor')->default(0);
            $table->boolean('has_original_money_receipt_of_doctor')->default(0);
            $table->boolean('has_original_itemized_pharmacy_bill')->default(0);
            $table->boolean('has_photocopy_of_physicians_prescription')->default(0);
            $table->boolean('original_receipt_of_each_lab_test')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_claim_requests', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('nature_of_illness');
            $table->dropColumn('hospital_address');
            $table->dropColumn('name_of_doctor');
            $table->dropColumn('prescribed_by_doctor');
            $table->dropColumn('has_original_money_receipt_of_doctor');
            $table->dropColumn('has_original_itemized_pharmacy_bill');
            $table->dropColumn('has_photocopy_of_physicians_prescription');
            $table->dropColumn('original_receipt_of_each_lab_test');
        });
    }
}
