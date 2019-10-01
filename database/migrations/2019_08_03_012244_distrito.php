<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Distrito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distrito', function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre', 100);
            $table->boolean('condicion');
            $table->integer('idcomunidad')->unsigned();
            $table->foreign('idcomunidad')->references('id')->on('comunidad');
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
        Schema::dropIfExists('distrito');
    }
}
