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
        Schema::create('envio_pedidos', function (Blueprint $table) {
            $table->id();
            $table->date('fechaEntrega');
            $table->string('descripcion');
            $table->unsignedBigInteger('pedido_id');
            $table->foreign( 'pedido_id' )->references( 'id' )->on( 'pedidos' )->onDelete('cascade');
            $table->unique('pedido_id'); // Esta línea agrega la restricción UNIQUE
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
        Schema::dropIfExists('envio_pedidos');
    }
};
