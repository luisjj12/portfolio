<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el producto (un comentario pertenece a un producto)
    public function product()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
