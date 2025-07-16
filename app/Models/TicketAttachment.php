<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TicketAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_response_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url', 'file_icon'];

    /**
     * Get the ticket response that owns the attachment.
     */
    public function ticketResponse()
    {
        return $this->belongsTo(TicketResponse::class);
    }

    /**
     * Get the URL to the file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->path);
    }

    /**
     * Get the appropriate icon for the file type.
     *
     * @return string
     */
    public function getFileIconAttribute()
    {
        $mimeType = $this->mime_type;
        
        if (str_contains($mimeType, 'image/')) {
            return 'fa-file-image';
        }
        
        if (str_contains($mimeType, 'pdf')) {
            return 'fa-file-pdf';
        }
        
        if (str_contains($mimeType, 'word') || 
            str_contains($mimeType, 'document') ||
            str_contains($this->original_name, '.doc')) {
            return 'fa-file-word';
        }
        
        if (str_contains($mimeType, 'excel') || 
            str_contains($mimeType, 'spreadsheet') ||
            str_contains($this->original_name, '.xls')) {
            return 'fa-file-excel';
        }
        
        if (str_contains($mimeType, 'text/plain') || 
            str_contains($this->original_name, '.txt')) {
            return 'fa-file-alt';
        }
        
        return 'fa-file';
    }
}
