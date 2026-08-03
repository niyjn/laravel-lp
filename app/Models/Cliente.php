<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Cliente extends Authenticatable
{
    protected $table = 'cliente';
    const UPDATED_AT = null;

    protected $fillable = ['nome', 'email', 'senha_hash'];
    protected $hidden = ['senha_hash'];
    protected $casts    = ['created_at' => 'datetime'];
    public function enderecos() {
        return $this->hasMany(Endereco::class, 'id_cliente');
    }

    public function pedidos() {
        return $this->hasMany(Pedido::class, 'id_cliente');
    }

    public function getAuthPassword() {
        return $this->senha_hash;
    }
}
