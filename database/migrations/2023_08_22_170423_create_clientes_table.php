<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('clientes', function (Blueprint $table) {
                $table->id("id");
                $table->unsignedBigInteger("user_id")->nullable();
                $table->string("nombre")->nullable();
                $table->string("tipo")->nullable();
                $table->string("email")->unique();
                $table->string("direccion")->nullable();
                $table->string("celular")->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');

            });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
