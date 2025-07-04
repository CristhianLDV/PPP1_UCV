<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id'); // Asegura que sea int(10) unsigned
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
         // Tabla intermedia para relación muchos a muchos
        Schema::create('employee_service', function (Blueprint $table) {
            $table->increments('id'); // Asegura que sea int(10) unsigned
                       // Usar unsignedInteger para compatibilidad con int(10) unsigned
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('service_id');

            // Relaciones
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

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
        Schema::dropIfExists('services');
        Schema::dropIfExists('employee_service');
    }
}
