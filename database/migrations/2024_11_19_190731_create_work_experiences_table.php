<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('employee_id')->comment('Employee ID');
            $table->string('sector')->comment('Sector publico o privado');
            $table->string('experience_type')->comment('tipo de experiencia');
            $table->string('entity')->comment('Entidad');
            $table->string('job_title')->comment('Cargo ocupado');
            $table->string('functions_performed')->comment('Funciones desempeñadas');
            $table->string('start_date')->comment('Fecha de inicio');
            $table->string('end_date')->comment('Fecha de fin');
            $table->string('document_name')->comment('Nombre del documento');
            $table->string('file')->comment('Ruta del archivo');
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
        Schema::dropIfExists('work_experiences');
    }
}
