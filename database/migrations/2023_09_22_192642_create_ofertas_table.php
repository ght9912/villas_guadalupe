<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertasTable extends Migration
{
    /**
    *Run the migrations.

    *@return void
    */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('zona_id');
            $table->unsignedBigInteger('lote_id');
            $table->unsignedBigInteger('cliente_id');
            $table->string('pago')->nullable();
            $table->string('plazo')->nullable();
            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('zona_id')->references('id')->on('etapas');
            $table->foreign('lote_id')->references('id')->on('lotes');
            $table->foreign('cliente_id')->references('id')->on('clientes');


        });
    }

    /**
    *Reverse the migrations.

    *@return void
    */
    public function down()
    {
        Schema::dropIfExists('ofertas');
    }
}
