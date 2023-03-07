<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string("username",35)->unique();
            $table->string("nombre",20);
            $table->string("apellidos",40)->nullable();
            $table->string("correo",50)->unique();
            $table->unsignedBigInteger("grupo");
            $table->text("password");
            $table->boolean("admin");

            $table->foreign('grupo')->references('id')->on('grupos')->onDelete("restrict")->onUpdate("restrict");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
