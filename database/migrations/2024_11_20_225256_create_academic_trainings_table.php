<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');

            $table->string('educational_level');
            $table->unsignedBigInteger('education_country_id');
            $table->string('education_study_center');
            
            $table->string('academic_situation');
            $table->string('academic_situation_start_year');
            $table->string('academic_situation_end_year');
            $table->unsignedBigInteger('academic_situation_city_id');
            $table->string('academic_degree');
            $table->string('academic_degree_level');
            $table->string('academic_degree_specialty');

            $table->string('qualification_title');
            $table->string('qualification_specialty');
            $table->string('qualification_expedition_date');
            $table->string('qualification_entity_control');
            $table->string('qualification_registration_center');
            $table->string('qualification_registration_number');
            $table->string('qualification_registration_date');
            $table->string('qualification_resolution_date');
            $table->string('qualification_resolution_number');
            $table->string('qualification_file');

            $table->string('tuition_school');
            $table->string('tuition_number');
            $table->string('tuition_date');
            $table->string('tuition_file');
            
            // $table->string('authorization_certificate');
            // $table->string('authorization_start_date');
            // $table->string('authorization_end_date');
            // $table->string('authorization_file');
            
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
        Schema::dropIfExists('academic_trainings');
    }
}
