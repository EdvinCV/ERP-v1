<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraEncabezadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_encabezados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('totalCompra', 12, 3)->default(0);
            $table->decimal('gastosParqueo', 12, 3)->default(0);
            $table->decimal('combustible', 12, 3)->default(0);
            $table->decimal('gastosVarios', 12, 3)->default(0);
            $table->decimal('impuestos', 12, 3)->default(0);
            $table->decimal('totalVenta', 12, 3)->default(0);
            $table->decimal('utilidadVenta', 12, 3)->default(0);
            $table->string('observaciones');
            $table->boolean('estado')->default(true);
            $table->boolean('finalizado')->default(false);
            $table->bigInteger('idEmpleado')->unsigned();
            $table->bigInteger('idEncargado')->unsigned();
            $table->timestamps();
            
            $table->foreign('idEncargado')->references('id')->on('users');
            $table->foreign('idEmpleado')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compra_encabezados');
    }
}
