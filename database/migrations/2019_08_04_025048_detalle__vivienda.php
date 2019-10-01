<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetalleVivienda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_vivienda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numvivienda');
            $table->date('fecha');
            $table->boolean('condicion');
            $table->string('direccion', 100);
            $table->integer('tenencia')->unsigned();
            $table->foreign('tenencia')->references('id')->on('tenencia');
            $table->integer('tipovivienda')->unsigned();
            $table->foreign('tipovivienda')->references('id')->on('tipovivienda');
            $table->integer('ambiente')->unsigned();
            $table->foreign('ambiente')->references('id')->on('ambiente');
            $table->integer('cocina')->unsigned();
            $table->foreign('cocina')->references('id')->on('cocina');
            $table->integer('techo')->unsigned();
            $table->foreign('techo')->references('id')->on('techo');
            $table->integer('pared')->unsigned();
            $table->foreign('pared')->references('id')->on('pared');
            $table->integer('piso')->unsigned();
            $table->foreign('piso')->references('id')->on('piso');
            $table->integer('aguaabastecimiento')->unsigned();
            $table->foreign('aguaabastecimiento')->references('id')->on('aguaabastecimiento');
            $table->integer('aguatrat')->unsigned();
            $table->foreign('aguatrat')->references('id')->on('aguatrat');
            $table->integer('eliminexcretas')->unsigned();
            $table->foreign('eliminexcretas')->references('id')->on('eliminexcretas');
            $table->integer('eliminbasura')->unsigned();
            $table->foreign('eliminbasura')->references('id')->on('eliminbasura');
            $table->integer('animalubic')->unsigned();
            $table->foreign('animalubic')->references('id')->on('animalubic');
            $table->integer('animalcondlugar')->unsigned();
            $table->foreign('animalcondlugar')->references('id')->on('animalcondlugar');
            $table->integer('perros');
            $table->integer('gatos');
            $table->boolean('electricidad');
            $table->boolean('telefonia');
            $table->string('radio');
            $table->string('otratenencia');
            $table->string('otrotecho');
            $table->string('otrapared');
            $table->string('otropiso');
            $table->string('otroabastagua');
            $table->string('otroelimexcretas');
            $table->string('otroelimbasura');
            $table->string('otroservicios');
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
        Schemma::dropIfExists('detalle_vivienda');
    }
}
