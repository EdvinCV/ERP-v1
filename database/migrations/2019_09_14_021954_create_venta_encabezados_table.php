<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaEncabezadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_encabezados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('total', 12, 3);
            $table->decimal('iva', 12, 3);
            $table->decimal('totalSinIVA', 12, 3);
            $table->string('serie',20)->nullable();
            $table->boolean('facturado');
            $table->integer('numeroFactura')->nullable();
            $table->bigInteger('idPersona')->unsigned();
            $table->bigInteger('idEmpleado')->unsigned();
            $table->bigInteger('idTipoPago')->unsigned();
            $table->string('cheque')->nullable();
            $table->string('banco')->nullable();
            //Llaves foráneas
            $table->foreign('idPersona')->references('id')->on('personas');
            $table->foreign('idEmpleado')->references('id')->on('users');
            $table->foreign('idTipoPago')->references('id')->on('tipo_pagos');
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
        Schema::dropIfExists('venta_encabezados');
    }
}
