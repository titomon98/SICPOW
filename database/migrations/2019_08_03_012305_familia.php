<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Familia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia', function (Blueprint $table){
            $table->increments('id');
            $table->date('fecha_inicial');
            $table->boolean('condicion');
            $table->string('sector', 10);
            $table->integer('num_vivienda');
            $table->integer('num_familia');
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')->references('id')->on('usuario');
            $table->integer('distrito')->unsigned();
            $table->foreign('distrito')->references('id')->on('distrito');
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
        Schema::dropIfExists('familia');
    }
}
