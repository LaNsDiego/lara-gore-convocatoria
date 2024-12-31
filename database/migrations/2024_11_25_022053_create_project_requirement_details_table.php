<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRequirementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_requirement_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('project_requirement_id');
            $table->string('dni');
            $table->string('first_name');
            $table->string('father_last_name');
            $table->string('mother_last_name');
            $table->decimal('amount_required',8,2);
            $table->decimal('amount_rrhh',8,2);
            $table->decimal('essalud',8,2);
            $table->decimal('total_amount',8,2);
            $table->string('observation');
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->text('job_profiles_selected')->nullable();

            $table->foreign('job_title_id')->references('id')->on('job_titles');
            $table->foreign('project_requirement_id')->references('id')->on('project_requirements');
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
        Schema::dropIfExists('project_requirement_details');
    }
}
