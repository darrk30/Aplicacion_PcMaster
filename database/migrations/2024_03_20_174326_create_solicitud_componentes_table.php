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
        Schema::create('solicitud_componentes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->string('estado');
            $table->unsignedBigInteger('orden_ensamblaje_id');
            $table->foreign('orden_ensamblaje_id')->references('id')->on('orden_ensamblajes')->onDelete('cascade');
            $table->unique('orden_ensamblaje_id'); // Esta línea agrega la restricción UNIQUE
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
        Schema::dropIfExists('solicitud_componentes');
    }
};
