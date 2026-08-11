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
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pedido_id');
            $table->enum('metodo_pago', ['tarjeta_credito', 'paypal', 'transferencia_bancaria', 'contra_entrega']);
            $table->decimal('monto', 10, 2);
            $table->enum('estado', ['pendiente', 'completado', 'fallido'])->default('pendiente');
            $table->timestamp('fecha_pago')->useCurrent();
            $table->timestamps();

            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
