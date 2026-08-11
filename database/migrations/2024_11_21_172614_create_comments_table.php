<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('comentario'); // Contenido del comentario
            $table->foreignId('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
