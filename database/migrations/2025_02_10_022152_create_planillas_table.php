<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planillas', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('is_civil',['ADMINISTRATIVO','O-I','O-II','O-III']);
            $table->unsignedBigInteger('project_requirement_detail_id');
            $table->unsignedBigInteger('dias_laborados');
            $table->unsignedBigInteger('cantidad_domingos');
            $table->unsignedBigInteger('cantidad_feriados');
            $table->unsignedBigInteger('hijos');
            $table->decimal('jornal_diario', 8, 2);
            $table->decimal('remuneracion_basica',8,2);
            $table->decimal('buc',8,2);
            $table->decimal('vacaciones_truncas',8,2);
            $table->decimal('cts',8,2);
            $table->decimal('movilidad',8,2);
            $table->decimal('escolaridad',8,2);
            $table->decimal('jornal_dominical',8,2);
            $table->decimal('gratificacion',8,2);
            $table->decimal('bonificacion_l29714',8,2);
            $table->decimal('pago_feriado',8,2);
            $table->decimal('total_remuneracion',8,2);
            
            $table->decimal('remuneracion_asegur',8,2);
            $table->decimal('essalud',8,2);
            $table->decimal('essalud_vida',8,2);
            $table->decimal('sctr',8,2);
            $table->decimal('crecer_seg',8,2);
            $table->decimal('total_aportes',8,2);
            
            $table->decimal('total',8,2);

            $table->foreign('project_requirement_detail_id')->references('id')->on('project_requirement_details');
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
        Schema::dropIfExists('planillas');
    }
}
