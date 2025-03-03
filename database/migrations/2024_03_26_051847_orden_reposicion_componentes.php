<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_reposicion_componentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orden_reposicion_id');
            $table->unsignedBigInteger('componente_id');
            $table->integer('cantidad');            
            $table->foreign('orden_reposicion_id')->references('id')->on('orden_reposicions')->onDelete('cascade');
            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
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
        Schema::dropIfExists('orden_reposicion_componentes');
    }
};
