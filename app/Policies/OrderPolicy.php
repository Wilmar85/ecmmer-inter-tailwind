<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determina si el usuario puede ver el pedido.
     */
    public function view(User $user, Order $order)
    {
        return $user->id === $order->user_id || $user->role === User::ROLE_ADMIN;
    }

    /**
     * Determina si el usuario puede actualizar el pedido.
     */
    public function update(User $user, Order $order)
    {
        return $user->role === User::ROLE_ADMIN;
    }
}
