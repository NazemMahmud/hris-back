<?php

use App\GenericSolution\GenericModelFields\Fields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDeceasedApprovalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_deceased_approval_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('emp_dece_id');
            $table->integer('enc_level_id');
            $table->string('status');
            $table->integer('next_level_id');
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
        Schema::dropIfExists('employee_deceased_approval_requests');
    }
}
