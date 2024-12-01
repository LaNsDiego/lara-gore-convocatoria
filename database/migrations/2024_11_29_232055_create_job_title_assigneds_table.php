<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTitleAssignedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_title_assigneds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('project_requirement_detail_id');
            $table->unsignedBigInteger('job_title_id');
            $table->text('selected_profiles')->default('[]');
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
        Schema::dropIfExists('job_title_assigneds');
    }
}
