<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'media_path',
        'thumbnail_path',
        'button_text',
        'button_url',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Obtener la URL completa del archivo multimedia
     */
    public function getMediaUrlAttribute()
    {
        return $this->media_path ? asset('storage/' . $this->media_path) : null;
    }

    /**
     * Obtener la URL completa de la miniatura
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    /**
     * Obtener la URL a utilizar en el slider
     */
    public function getUrlAttribute()
    {
        return $this->media_url;
    }

    /**
     * Obtener los sliders activos ordenados
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('created_at', 'desc');
    }
}
