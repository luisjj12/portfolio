<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Items_pedido extends Model
{
    use HasFactory;

    public function productos(): BelongsTo
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }

    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
