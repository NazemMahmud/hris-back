<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialChildrenBenefitFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_children_benefit_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('special_children_benefit_id');
            $table->string('file_type');
            $table->string('file_path');
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
        Schema::dropIfExists('special_children_benefit_files');
    }
}
