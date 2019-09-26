<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idProducto')->unsigned();
            $table->integer('cantidad');
            $table->decimal('precioCompra', 12, 3)->default(0);
            $table->decimal('totalCompra', 12, 3)->default(0);
            $table->decimal('precioVenta', 12, 3)->default(0);
            $table->decimal('totalVenta', 12, 3)->default(0);
            $table->bigInteger('idCompraEncabezado')->unsigned();
            $table->bigInteger('idPersona')->unsigned();
            $table->foreign('idPersona')->references('id')->on('personas');

            $table->foreign('idProducto')->references('id')->on('productos');
            $table->foreign('idCompraEncabezado')->references('id')->on('compra_encabezados');
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
        Schema::dropIfExists('compra_detalles');
    }
}
