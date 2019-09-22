<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rolId');
            $table->unsignedInteger('permisoId');
            $table->boolean('estado')->default(true);

            $table->foreign('rolId')->references('id')->on('rols');
            $table->foreign('permisoId')->references('id')->on('permisos');

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
        Schema::dropIfExists('rol_permisos');
    }
}
