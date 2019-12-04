<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TravelInvoiceApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_invoice_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('travel_id');
            $table->bigInteger('travel_invoice_id');
            $table->bigInteger('previous_level')->nullable();
            $table->bigInteger('current_level');
            $table->bigInteger('next_level')->nullable();
            $table->bigInteger('approved_by');
            $table->char('status', 30);
            Fields::MakeCommonField($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_invoice_approval');
    }
}
