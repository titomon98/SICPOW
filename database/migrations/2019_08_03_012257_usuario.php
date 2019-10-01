<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre', 300);
            $table->string('correo', 100)->unique();
            $table->string('password', 150);
            $table->boolean('condicion');
            $table->string('direccion', 150);
            $table->string('CUI', 20);
            $table->string('telefono', 25);
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('rol');
            $table->rememberToken();
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
        Schema::dropIfExists('usuario');
    }
}
