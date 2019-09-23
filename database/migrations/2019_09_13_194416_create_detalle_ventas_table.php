<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('subtotal', 12, 3);
            $table->integer('cantidad');
            $table->decimal('descuento',12,3);
            $table->bigInteger('idProducto')->unsigned();
            $table->bigInteger('idVentaEncabezado')->unsigned();

            $table->foreign('idProducto')->references('id')->on('productos');
            $table->foreign('idVentaEncabezado')->references('id')->on('venta_encabezados');
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
        Schema::dropIfExists('detalle_ventas');
    }
}
