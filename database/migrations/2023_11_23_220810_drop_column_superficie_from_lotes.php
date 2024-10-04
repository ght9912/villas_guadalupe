<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
Ejecutar en el siguiente orden:
    php artisan migrate --path=database\migrations\2023_11_23_220810_drop_column_superficie_from_lotes.php
    php artisan migrate --path=database\migrations\2023_11_23_215921_update_superficie_as_float.php
    php artisan migrate --path=database\migrations\2023_11_23_214856_add_vertices_medidas_and_colindancias_to_lotes.php
NO EJECUTAR DIRECTAMENTE php artisan migrate
*/

class DropColumnSuperficieFromLotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotes', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropColumn('superficie');
        });
    }
}
