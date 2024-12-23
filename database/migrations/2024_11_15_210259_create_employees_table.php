<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {

            // DATOS PERSONALES
            $table->increments('id')->comment('Identificador de empleado');
            $table->string('executor_unit')->comment('Unidad Ejecutora');
            $table->string('document_type')->comment('Tipo de documento');
            $table->string('document_number')->comment('Número de documento');
            $table->string('first_name')->comment('Nombre del empleado');
            $table->string('mother_last_name')->comment('Nombre del empleado');
            $table->string('father_last_name')->comment('Nombre del empleado');
            $table->enum('sex',['MASCULINO','FEMENINO'])->comment('Sexo del empleado');
            $table->enum('marital_status',['SOLTERO','CASADO','VIUDO'])->comment('Estado civil del empleado');
            $table->string('date_of_birth')->comment('Fecha de nacimiento del empleado');
            $table->string('phone_number')->nullable()->comment('Número de teléfono o celular');
            $table->string('email')->nullable()->comment('Correo electrónico');
            $table->string('file_data_employee')->default('')->comment('Archivo adjunto de datos personales');
            
            // DATOS DEL LUGAR DE NACIMIENTO
            $table->unsignedBigInteger('birth_city_id')->comment('Identificador del distrito');
            $table->foreign('birth_city_id')->references('id')->on('cities')->comment('Clave foránea del distrito');
            $table->string('file_place_of_birth')->default('')->comment('Archivo adjunto de la lugar de nacimiento');

            // DATOS DE DIRECCION
            $table->unsignedBigInteger('address_city_id')->comment('Identificador del distrito');
            $table->foreign('address_city_id')->references('id')->on('cities')->comment('Clave foránea de la distrito');
            $table->string('address')->comment('Direccion del empleado');
            $table->string('file_address')->default('')->comment('Archivo adjunto de la dirección');

            // DATOS BANCARIOS
            $table->string('bank')->comment('Banco del empleado');
            $table->string('account_number')->comment('Número de cuenta');
            $table->string('cci')->comment('Código de cuenta interbancario');
            $table->string('account_type')->comment('Tipo de cuenta');
            $table->string('file_bank_account')->default('')->comment('Archivo adjunto de la cuenta');
            
            // RELACIONES
            

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
        Schema::dropIfExists('employees');
    }
}
