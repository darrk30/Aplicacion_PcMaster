<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('componente_kardex', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kardex_id')->nullable();
            $table->unsignedBigInteger('componente_id')->nullable();
            $table->integer('cantidad')->nullable();
            // Llaves foráneas
            $table->foreign('kardex_id')->references('id')->on('kardexes')->onDelete('cascade');
            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
            $table->timestamps();                        
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('componente_kardex');
    }
};
