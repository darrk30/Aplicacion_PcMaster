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
        Schema::create('pedido_componentes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('componente_id');
            $table->foreign( 'componente_id' )->references( 'id' )->on( 'componentes' );

            $table->unsignedBigInteger('pedido_id');
            $table->foreign( 'pedido_id' )->references( 'id' )->on( 'pedidos' )->onDelete('cascade');

            $table->integer('cantidad');
            $table->double('subTotal');
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
        Schema::dropIfExists('pedido_componentes');
    }
};
