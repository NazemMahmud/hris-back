<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalClaimItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_claim_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('medical_claim_request_id');
            $table->string('receipt_description');
            $table->double('requested_amount');
            $table->double('settled_amount')->nullable();
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
        Schema::dropIfExists('medical_claim_items');
    }
}
