<?php

namespace App\Mail;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The ticket instance.
     *
     * @var \App\Models\SupportTicket
     */
    public $ticket;

    /**
     * Indica si el correo es para el administrador.
     *
     * @var bool
     */
    public $isForAdmin;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\SupportTicket  $ticket
     * @param  bool  $isForAdmin
     * @return void
     */
    public function __construct(SupportTicket $ticket, bool $isForAdmin = false)
    {
        $this->ticket = $ticket->load('user');
        $this->isForAdmin = $isForAdmin;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if ($this->isForAdmin) {
            return new Envelope(
                subject: 'Nuevo Ticket de Soporte #' . $this->ticket->reference_number,
            );
        }

        return new Envelope(
            subject: 'Tu ticket de soporte ha sido creado #' . $this->ticket->reference_number,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $view = $this->isForAdmin 
            ? 'emails.support.admin.ticket-created' 
            : 'emails.support.ticket-created';

        return new Content(
            markdown: $view,
            with: [
                'ticket' => $this->ticket,
                'user' => $this->ticket->user,
                'isForAdmin' => $this->isForAdmin,
                'url' => route('support.tickets.show', $this->ticket),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
