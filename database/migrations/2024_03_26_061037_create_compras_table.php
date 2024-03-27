<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Código único para cada compra
            $table->date('fecha'); // Fecha de la compra
            $table->date('fechaEntrega');
            $table->double('precioTotal');            
            $table->unsignedBigInteger('proveedor_id'); // ID del proveedor asociado a la compra
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade'); // Clave foránea para relación con proveedores
            $table->unsignedBigInteger('orden_reposicion_id'); // ID del proveedor asociado a la compra
            $table->foreign('orden_reposicion_id')->references('id')->on('orden_reposicions')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
};
