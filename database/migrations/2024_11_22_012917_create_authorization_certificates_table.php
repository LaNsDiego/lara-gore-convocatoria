<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorization_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('academic_training_id');
            $table->string('authorization_certificate');
            $table->string('authorization_start_date');
            $table->string('authorization_end_date');
            $table->string('authorization_file');
            $table->foreign('academic_training_id')->references('id')->on('academic_trainings');
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
        Schema::dropIfExists('authorization_certificates');
    }
}
