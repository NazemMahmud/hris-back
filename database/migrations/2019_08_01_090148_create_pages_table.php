<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('translate')->nullable(); // description
            $table->string('link')->nullable();
            $table->bigInteger('parent_id')->unsigned()->default(0);
            $table->integer('level')->nullable();
            $table->string('type')->nullable();
            $table->string('icon')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDefault')->default(1);
            $table->timestamps();
//            ALTER TABLE table_name MODIFY password varchar(20) AFTER id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
