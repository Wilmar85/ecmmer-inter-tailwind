<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketRating;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TicketRatingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created rating in storage.
     */
    public function store(Request $request, SupportTicket $ticket)
    {
        $this->authorize('rate', $ticket);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verificar si el usuario ya calificó este ticket
        $rating = $ticket->ratings()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        // Actualizar el estado del ticket a "cerrado" si es que no está ya cerrado
        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'closed']);
        }

        return response()->json([
            'success' => true,
            'message' => __('support.messages.rating_submitted'),
            'rating' => $rating->load('user')
        ]);
    }

    /**
     * Update the specified rating in storage.
     */
    public function update(Request $request, TicketRating $rating)
    {
        $ticket = $rating->ticket;
        $this->authorize('updateRating', [$ticket, $rating]);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => __('support.messages.rating_updated'),
            'rating' => $rating->load('user')
        ]);
    }

    /**
     * Remove the specified rating from storage.
     */
    public function destroy(TicketRating $rating)
    {
        $ticket = $rating->ticket;
        $this->authorize('deleteRating', [$ticket, $rating]);
        
        $rating->delete();

        return response()->json([
            'success' => true,
            'message' => __('support.messages.rating_deleted')
        ]);
    }
}
