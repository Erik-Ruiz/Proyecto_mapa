<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntoEtiquetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_etiquetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("etiqueta");
            $table->unsignedBigInteger("punto");
            $table->boolean("personal");
            $table->unsignedBigInteger("usuario")->nullable();

            $table->foreign('usuario')->references('id')->on('usuarios')->onDelete("restrict")->onUpdate("restrict");
            $table->foreign('etiqueta')->references('id')->on('etiquetas')->onDelete("restrict")->onUpdate("restrict");
            $table->foreign('punto')->references('id')->on('puntos')->onDelete("restrict")->onUpdate("restrict");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punto_etiquetas');
    }
}
