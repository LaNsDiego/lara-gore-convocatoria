<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSystemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('system_modules', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador del módulo del sistema.');
            $table->string('name')->comment('Nombre del módulo del sistema.');
            $table->string('description')->comment('Descripción del módulo del sistema.');
            $table->unsignedBigInteger('module_group_id')->comment('Identificador del grupo de los módulos del sistema.');
            $table->foreign('module_group_id')->references('id')->on('module_groups');
            $table->timestamps();
            $table->softDeletes('deleted_at');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('system_modules');
    }
};
