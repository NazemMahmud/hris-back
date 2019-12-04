<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDeceasedMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_deceased_money', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->integer('staff_id')->nullable();
            $table->integer('money');
            $table->timestamps();
            Fields::AddCommonField($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_deceased_money');
    }
}
