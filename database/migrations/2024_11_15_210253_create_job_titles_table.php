<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_titles', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador de cargo');
            $table->string('executor_unit')->comment('Unidad Ejecutora');
            $table->string('code')->comment('Código del cargo');
            $table->string('name')->comment('Nombre del cargo');
            $table->text('observation')->comment('Observacion del cargo');
            $table->string('status')->comment('Estado del cargo');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_titles');
    }
}
