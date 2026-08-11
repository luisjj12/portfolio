<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito_compras extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
    
}
