<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioPruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_pruebas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("usuario");
            $table->unsignedBigInteger("prueba");

            $table->foreign('usuario')->references('id')->on('usuarios')->onDelete("restrict")->onUpdate("restrict");
            $table->foreign('prueba')->references('id')->on('pruebas')->onDelete("restrict")->onUpdate("restrict");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_pruebas');
    }
}
