<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('libro_id');
            $table->datetime('fecha_prestamo');
            $table->datetime('fecha_devolucion');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('libro_id')->references('id')->on('libros');
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
        Schema::dropIfExists('prestamos');
    }
}
