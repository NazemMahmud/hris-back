<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDayCares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_cares', function (Blueprint $table) {
            $table->string('guardian_name')->after('children_id')->nullable();
            $table->string('guardian_contract_number')->after('children_id')->nullable();
            $table->text('justification')->after('children_id')->nullable();
            $table->integer('declaration')->after('children_id')->nullable();
            $table->integer('isDeleted')->after('isActive')->nullable();
            $table->integer('status')->after('isActive')->default(0);
            $table->dropColumn('softDelete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_cares', function (Blueprint $table) {
            //
        });
    }
}
