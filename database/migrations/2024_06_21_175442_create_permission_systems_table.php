<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionSystemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permission_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('system_module_id')->comment('modulo al que se le asigna el permiso con su acción');
            $table->string('action')->comment('crear , actualizar , borrar y ver un recurso');
            $table->foreign('system_module_id')->references('id')->on('system_modules');
            
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('permission_systems');
    }
};
