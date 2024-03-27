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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');           
            $table->string('apellidos', 100)->nullable();
            $table->string('telefono',9)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('documento_id')->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('set null');       
            $table->string('numeroDoc',20)->nullable(); 
            $table->string('direccion')->nullable();
            $table->integer('vigente')->nullable();                                   
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
