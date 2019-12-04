<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialChildrenBenefitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_children_benefit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staff_id');
            $table->bigInteger('children_id');
            $table->boolean('formal_assessment')->default(0);
            $table->boolean('medical_records')->default(0);
            $table->boolean('children_education_allowance')->default(0);
            $table->string('school_name')->nullable();
            $table->boolean('not_school_age')->default(0);
            $table->boolean('regular_school')->default(0);
            $table->boolean('other_support')->default(0);
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
        Schema::dropIfExists('special_children_benefit');
    }
}
