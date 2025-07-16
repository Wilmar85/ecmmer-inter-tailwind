<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketResponse;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketResponseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SupportTicket $ticket)
    {
        $this->authorize('respond', $ticket);

        $validated = $request->validate([
            'content' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
        ]);

        // Crear la respuesta
        $response = $ticket->responses()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_customer_response' => Auth::user()->isCustomer(),
        ]);

        // Manejar archivos adjuntos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('ticket_attachments', 'public');
                
                $response->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        // Si es una respuesta del personal de soporte, marcar como en espera de respuesta del cliente
        if (!Auth::user()->isCustomer()) {
            $ticket->update(['status' => 'awaiting_response']);
        } else {
            // Si es una respuesta del cliente, marcar como en progreso
            $ticket->update(['status' => 'in_progress']);
        }

        // Enviar notificación por correo electrónico
        // Mail::to($ticket->user->email)->queue(new TicketResponseMail($ticket, $response));

        return redirect()
            ->route('support.tickets.show', $ticket)
            ->with('success', __('support.messages.response_sent'));
    }

    /**
     * Descargar un archivo adjunto
     */
    public function downloadAttachment(TicketAttachment $attachment)
    {
        $this->authorize('view', $attachment->ticketResponse->ticket);

        if (!Storage::disk('public')->exists($attachment->path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $attachment->path, 
            $attachment->original_name
        );
    }
}
