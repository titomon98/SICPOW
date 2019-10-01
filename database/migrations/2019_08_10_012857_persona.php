<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('apellido_casada', 30);
            $table->boolean('lider');
            $table->boolean('sexo');
            $table->date('nacimiento');
            $table->string('CUI', 20);
            $table->integer('familia')->unsigned();
            $table->foreign('familia')->references('id')->on('familia');
            $table->integer('parentesco')->unsigned();
            $table->foreign('parentesco')->references('id')->on('parentesco');
            $table->integer('pueblo')->unsigned();
            $table->foreign('pueblo')->references('id')->on('pueblo');
            $table->integer('comlinguistica')->unsigned();
            $table->foreign('comlinguistica')->references('id')->on('comlinguistica');
            $table->boolean('alfabetismo');
            $table->integer('escolaridad')->unsigned();
            $table->foreign('escolaridad')->references('id')->on('escolaridad');
            $table->integer('discapacidad')->unsigned();
            $table->foreign('discapacidad')->references('id')->on('discapacidad');
            $table->integer('ocupacion')->unsigned();
            $table->foreign('ocupacion')->references('id')->on('ocupacion');
            $table->boolean('migracion');
            $table->integer('permanencia')->unsigned();
            $table->foreign('permanencia')->references('id')->on('permanencia');
            $table->string('commigracion', 100);
            $table->string('munmigracion', 100);
            $table->string('depmigracion', 100);
            $table->integer('pais')->unsigned();
            $table->foreign('pais')->references('id')->on('paismigracion');
            $table->integer('puesto_comunidad')->unsigned();
            $table->foreign('puesto_comunidad')->references('id')->on('puesto_comunidad');
            $table->boolean('mortalidad');
            $table->date('fechamortalidad');
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
        Schema::dropIfExists('persona');
    }
}
