<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('employee_id'); // ID de empleado
            $table->string('study_type'); // Tipo de estudio
            $table->string('topic'); // Tema
            $table->string('start_date'); // Fecha de inicio
            $table->string('end_date'); // Fecha de fin
            $table->string('participation_type'); // Tipo de participación
            $table->string('institution'); // Institución
            $table->unsignedBigInteger('country_id'); // ID del país
            // $table->unsignedBigInteger('department_id'); // ID del departamento
            // $table->unsignedBigInteger('provincie_id'); // ID de la provincia
            $table->unsignedBigInteger('city_id'); // ID de la ciudad
            $table->string('date_expedition'); // Fecha de expedición
            $table->string('qualification_entity_control'); // Entidad calificadora
            $table->string('issue_date'); // Fecha de emisión
            $table->string('registry_number'); // Número de registro
            $table->string('registry_center'); // Centro de registro
            $table->string('date_resolution'); // Fecha de resolución
            $table->string('number_resolution'); // Número de resolución
            $table->string('file')->nullable(); // Ruta del archivo (opcional)
            $table->integer('hours')->nullable(); // Ruta del archivo (opcional)
            $table->integer('credits')->nullable(); // Ruta del archivo (opcional)
            $table->string('file_register')->nullable(); // Ruta del archivo (opcional)
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
        Schema::dropIfExists('trainings');
    }
}
