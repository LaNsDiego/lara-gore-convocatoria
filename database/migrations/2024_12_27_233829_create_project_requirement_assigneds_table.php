<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRequirementAssignedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_requirement_assigneds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('project_requeriment_id');
            $table->unsignedBigInteger('user_id');

            
            $table->foreign('project_requeriment_id')->references('id')->on('project_requirements')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('project_requirement_assigneds');
    }
}
