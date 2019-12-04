<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInMedicalClaimRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_claim_requests', function (Blueprint $table) {
            $table->double('claimed_amount');
            $table->double('settled_amount');
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
            $table->dropColumn('claimed_amount');
            $table->dropColumn('settled_amount');
        });
    }
}
