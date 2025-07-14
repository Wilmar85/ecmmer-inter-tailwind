<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determina si el usuario puede actualizar el producto.
     */
    public function update(User $user, Product $product)
    {
        return $user->role === User::ROLE_ADMIN;
    }

    /**
     * Determina si el usuario puede eliminar el producto.
     */
    public function delete(User $user, Product $product)
    {
        return $user->role === User::ROLE_ADMIN;
    }
}
