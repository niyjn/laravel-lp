<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'cliente';
    const UPDATED_AT = null;

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'role',
        'is_admin',
    ];

    protected $hidden = [
        'senha_hash',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'id_cliente');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente');
    }

    public function getAuthPassword()
    {
        return $this->senha_hash;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || (bool) $this->is_admin;
    }

    public function isGerente(): bool
    {
        return $this->role === 'gerente';
    }

    public function isUsuario(): bool
    {
        return $this->role === 'usuario' || (! $this->isAdmin() && ! $this->isGerente());
    }

    public function hasRole(string ...$roles): bool
    {
        if (in_array('admin', $roles, true) && $this->isAdmin()) {
            return true;
        }

        return in_array($this->role, $roles, true);
    }
}
