<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\GenericSolution\GenericModelFields\Fields;

class TravelInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('travel_id');
            $table->bigInteger('total_cost');
            $table->int('status')->default(0);
            $table->text('remark')->nullable();;
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
        Schema::dropIfExists('travel_invoices');
    }
}
