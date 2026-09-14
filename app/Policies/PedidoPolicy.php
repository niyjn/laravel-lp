<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\Pedido;

class PedidoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Cliente $user): bool
    {
        return $user->isAdmin() || $user->isGerente();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Cliente $user, Pedido $pedido): bool
    {
        return $user->isAdmin() || $user->isGerente() || $user->id === $pedido->id_cliente;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Cliente $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model status.
     */
    public function updateStatus(Cliente $user, Pedido $pedido): bool
    {
        return $user->isAdmin() || $user->isGerente();
    }
}
