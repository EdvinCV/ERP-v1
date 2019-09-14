<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idcategoria')->unsigned();
            $table->bigInteger('idpresentacion')->unsigned();
            $table->bigInteger('idpersona')->unsigned();
            $table->string('nombre',200);
            $table->decimal('precioventa', 12, 3);
            $table->decimal('preciocompra', 12, 3);
            $table->decimal('gastocomercializacion', 12, 3)->nullable();
            $table->decimal('utilidad', 12, 3);
            $table->decimal('impuesto', 12, 4)->nullable();
            $table->decimal('maximoprecio', 12, 3)->nullable();
            $table->decimal('minimoprecio', 12, 3)->nullable();
            $table->boolean('estado')->default(1);
            $table->string('codigo',20)->unique();
            $table->float('cantidadapartado')->nullable();
            $table->float('existencia')->nullable();
            $table->timestamps();

            $table->foreign('idcategoria')->references('id')->on('categorias');
            $table->foreign('idpersona')->references('id')->on('personas');
            $table->foreign('idpresentacion')->references('id')->on('presentacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
