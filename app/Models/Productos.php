<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'descuento',
        'stock',
        'categoria_id',
        'vendedor_id',
        'imagen',
    ];

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentarios::class, 'producto_id');  // Relación inversa con la clave foránea 'product_id' en comentarios
    }

    public function carrito(): HasMany
    {
        return $this->hasMany(Carrito_compras::class, 'producto_id');
    }

    public function items_pedido(): HasMany
    {
        return $this->hasMany(Items_pedido::class, 'producto_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}
