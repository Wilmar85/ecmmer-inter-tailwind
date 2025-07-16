<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\TicketResponse;
use App\Models\TicketRating;

class SupportTicket extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'email',
        'subject',
        'description',
        'status',
        'priority',
        'reference_number'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->reference_number = 'TICKET-' . strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id')->with('user', 'attachments')->latest();
    }

    /**
     * Obtener todos los archivos adjuntos del ticket
     */
    public function attachments()
    {
        return $this->hasManyThrough(
            'App\Models\TicketAttachment',
            'App\Models\TicketResponse',
            'ticket_id', // Clave foránea en la tabla TicketResponse
            'ticket_response_id', // Clave foránea en la tabla TicketAttachment
            'id', // Clave local en la tabla SupportTicket
            'id' // Clave local en la tabla TicketResponse
        );
    }

    /**
     * Obtener la última respuesta del ticket
     */
    public function latestResponse()
    {
        return $this->hasOne(TicketResponse::class, 'ticket_id')->latestOfMany();
    }

    /**
     * Obtener las respuestas del personal de soporte
     */
    public function staffResponses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id')
            ->where('is_customer_response', false)
            ->with('user');
    }

    /**
     * Obtener las respuestas del cliente
     */
    public function customerResponses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id')
            ->where('is_customer_response', true)
            ->with('user');
    }

    public function ratings()
    {
        return $this->hasOne(TicketRating::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeAwaitingResponse($query)
    {
        return $query->where('status', 'awaiting_response');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Marcar el ticket como leído
     *
     * @return void
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Marcar el ticket como no leído
     *
     * @return void
     */
    public function markAsUnread()
    {
        if (!is_null($this->read_at)) {
            $this->forceFill(['read_at' => null])->save();
        }
    }

    /**
     * Determinar si el ticket ha sido leído
     *
     * @return bool
     */
    public function read()
    {
        return $this->read_at !== null;
    }

    /**
     * Determinar si el ticket no ha sido leído
     *
     * @return bool
     */
    public function unread()
    {
        return $this->read_at === null;
    }

    /**
     * Obtener el tiempo de lectura en formato legible
     *
     * @return string|null
     */
    public function readAt()
    {
        return $this->read_at ? $this->read_at->diffForHumans() : null;
    }
}
