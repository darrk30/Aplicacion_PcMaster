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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->dateTime('fechaPedido');
            $table->text('descripcion', 200);
            $table->date('fechaEntrega');
            $table->string('estadoPedido');
            $table->double('montoTotal');
            $table->string('estadoPago');
            $table->string('vigente');
            // //clave foranea de clientes
            // $table->unsignedBigInteger('cliente_id');
            // $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict'); 
            // //clave foranea de usuarios
            // $table->unsignedBigInteger('users_id');
            // $table->foreign('users_id')->references('id')->on('users')->onDelete('restrict'); 
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('NO ACTION'); // Cambiar 'restrict' por 'NO ACTION' para SQL Server

            // Clave foránea de usuarios
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('NO ACTION');
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
        Schema::dropIfExists('pedidos');
    }
};
