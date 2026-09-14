<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\Endereco;

class EnderecoPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(Cliente $user, Endereco $endereco): bool
    {
        return $user->id === $endereco->id_cliente;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Cliente $user, Endereco $endereco): bool
    {
        return $user->id === $endereco->id_cliente;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Cliente $user, Endereco $endereco): bool
    {
        return $user->id === $endereco->id_cliente;
    }
}
