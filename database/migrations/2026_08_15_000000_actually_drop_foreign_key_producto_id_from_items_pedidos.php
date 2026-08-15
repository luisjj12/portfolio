<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Las migraciones "drop_foreign_key(s)_from_items_pedidos" de 2025 se quedaron
     * vacías por error: la clave foránea con borrado en cascada seguía activa,
     * así que al borrar un producto (o al borrar un vendedor, lo que borra sus
     * productos) se borraba también el historial de pedidos de cualquier cliente
     * que lo hubiera comprado. Esta migración sí quita esa clave foránea.
     */
    public function up(): void
    {
        Schema::table('items_pedidos', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items_pedidos', function (Blueprint $table) {
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }
};
