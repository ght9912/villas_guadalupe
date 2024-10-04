<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->bigIncrements('id');
        $table->integer('lote');
        $table->integer('manzana');
        $table->unsignedBigInteger('proyecto_id');
        $table->unsignedBigInteger('etapa_id');
        $table->string('ubicacion')->nullable();
        $table->integer('superficie')->nullable();
        $table->unsignedBigInteger('comprador_id')->nullable();
        $table->unsignedBigInteger('vendedor_id')->nullable();
        $table->timestamps();

        $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
        $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
        $table->foreign('comprador_id')->references('id')->on('clientes');
        $table->foreign('vendedor_id')->references('id')->on('vendedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotes');
    }
}
