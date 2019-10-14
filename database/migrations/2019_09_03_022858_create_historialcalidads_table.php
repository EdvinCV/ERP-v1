<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialcalidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historialcalidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('calificacion');
            $table->bigInteger('idproducto')->unsigned();
            $table->date('fecha');
            $table->string('descripcion',500);
            $table->timestamps();
            $table->foreign('idproducto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historialcalidads');
    }
}
