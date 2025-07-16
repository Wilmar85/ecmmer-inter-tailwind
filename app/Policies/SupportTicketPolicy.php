<?php

namespace App\Policies;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SupportTicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Cualquier usuario autenticado puede ver sus propios tickets
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SupportTicket $ticket): bool
    {
        // El usuario puede ver el ticket si es el dueño o es administrador
        return $user->id === $ticket->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear tickets
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SupportTicket $ticket): bool
    {
        // Solo los administradores pueden actualizar los tickets
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can respond to the ticket.
     */
    public function respond(User $user, SupportTicket $ticket): bool
    {
        // Solo los administradores pueden responder a los tickets
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SupportTicket $ticket): bool
    {
        // Solo administradores pueden eliminar tickets
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the ticket dashboard.
     */
    public function viewDashboard(User $user): bool
    {
        // Solo administradores y equipo de soporte pueden ver el dashboard
        return $user->isSupportAgent() || $user->isAdmin();
    }
    
    /**
     * Determine whether the user can rate the ticket.
     */
    public function rate(User $user, SupportTicket $ticket): bool
    {
        // Solo el dueño del ticket puede calificarlo y solo si está resuelto o cerrado
        return $user->id === $ticket->user_id && 
               in_array($ticket->status, ['resolved', 'closed']) &&
               !$ticket->ratings()->where('user_id', $user->id)->exists();
    }
    
    /**
     * Determine whether the user can update a rating.
     */
    public function updateRating(User $user, SupportTicket $ticket, TicketRating $rating): bool
    {
        // Solo el dueño de la calificación puede actualizarla
        return $user->id === $rating->user_id && $rating->ticket_id === $ticket->id;
    }
    
    /**
     * Determine whether the user can delete a rating.
     */
    public function deleteRating(User $user, SupportTicket $ticket, TicketRating $rating): bool
    {
        // Solo el dueño de la calificación o un administrador pueden eliminarla
        return ($user->id === $rating->user_id || $user->isAdmin()) && 
               $rating->ticket_id === $ticket->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SupportTicket $supportTicket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SupportTicket $supportTicket): bool
    {
        return false;
    }
}
