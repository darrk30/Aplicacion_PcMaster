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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->string('tipoTransaccion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->unsignedBigInteger('solicitud_componente_id')->nullable();
            // Llaves foráneas
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->nullable();
            $table->foreign('solicitud_componente_id')->references('id')->on('solicitud_componentes')->nullable();
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
        Schema::dropIfExists('kardexes');
    }
};
