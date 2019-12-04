<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TravelInvoiceIteams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('travel_invoice_id');
            $table->string('name');
            $table->bigInteger('cost');
            $table->bigInteger('attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_invoice_items');
    }
}
