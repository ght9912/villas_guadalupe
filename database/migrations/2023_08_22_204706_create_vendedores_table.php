<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedores', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('celular', 10)->nullable();
            $table->string("clientes")->nullable();
            $table->string('referencia')->nullable();
            $table->float('comisiones', 8, 2)->nullable();
            $table->string('proyectos_participa')->nullable();
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
        Schema::dropIfExists('vendedors');
    }
}
