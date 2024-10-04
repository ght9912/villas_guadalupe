<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->onDelete('cascade');
            $table->string('ruta');
            $table->string('descripcion');
            $table->string('alt'); //Texto alternativo a la imagen
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
        Schema::dropIfExists('fotos_lotes');
    }
}
