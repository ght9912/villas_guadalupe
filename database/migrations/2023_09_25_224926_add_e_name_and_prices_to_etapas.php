<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddENameAndPricesToEtapas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->string('e_name')->nullable()->after('etapa');
            $table->float('precio_cont',4,2,false)->nullable()->after('ubicacion');
            $table->float('precio_fin',4,2,false)->nullable()->after('precio_cont');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->dropColumn('lotes');
        });
    }
}
