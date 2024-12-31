<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodRequirementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_requirement_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('project_requirement_detail_id');
            $table->unsignedBigInteger('year');
            $table->string('start_month_name');
            $table->string('end_month_name');
            $table->string('start_date');
            $table->string('end_date');
            $table->text('observation');

            $table->foreign('project_requirement_detail_id')->references('id')->on('project_requirement_details');
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('period_requirement_details');
    }
}
