<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\Produto;

class ProdutoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Cliente $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Cliente $user, Produto $produto): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Cliente $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Cliente $user, Produto $produto): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Cliente $user, Produto $produto): bool
    {
        return $user->isAdmin();
    }
}
