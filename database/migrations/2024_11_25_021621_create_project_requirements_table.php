<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('functional_sequence');
            $table->string('specific_expenditure');
            $table->string('project_name');
            $table->string('amount_as_specified');
            $table->boolean('is_freeze')->default(false);
            $table->string('executor_unit');

            $table->string('dni_responsible');
            $table->string('full_name_responsible');
            $table->string('document_type');
            $table->string('document_number');



            // employeeRequirements
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
        Schema::dropIfExists('project_requirements');
    }
}
