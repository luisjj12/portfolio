<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Productos;


class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'calle',
        'ciudad',
        'codigo_postal',
        'pais',
        'nombre_empresa',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function productos(): HasMany
    {
        return $this->hasMany(Productos::class, 'vendedor_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentarios::class, 'usuario_id');
    }

    public function carrito(): HasMany
    {
        return $this->hasMany(Carrito_compras::class, 'usuario_id');
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Items_pedido::class, 'usuario_id');
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }
}
