<?php

namespace App\Mail;

use App\Models\SupportTicket;
use App\Models\TicketResponse as TicketResponseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketResponse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The ticket instance.
     *
     * @var \App\Models\SupportTicket
     */
    public $ticket;

    /**
     * The response instance.
     *
     * @var \App\Models\TicketResponse
     */
    public $response;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\SupportTicket  $ticket
     * @param  \App\Models\TicketResponse  $response
     * @return void
     */
    public function __construct(SupportTicket $ticket, TicketResponseModel $response)
    {
        $this->ticket = $ticket;
        $this->response = $response;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $subject = $this->response->is_customer_response
            ? __('support.email.ticket_response.subject', ['reference' => $this->ticket->reference_number])
            : __('support.email.ticket_updated.subject', ['reference' => $this->ticket->reference_number]);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $markdown = $this->response->is_customer_response
            ? 'emails.support.ticket-response'
            : 'emails.support.ticket-updated';

        return new Content(
            markdown: $markdown,
            with: [
                'ticket' => $this->ticket,
                'response' => $this->response,
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
