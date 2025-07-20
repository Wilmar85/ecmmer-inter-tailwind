<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        // Si no hay ruta de imagen, retornar un placeholder
        if (empty($this->image_path)) {
            return asset('images/placeholder.jpg');
        }
        
        // Si ya es una URL completa, retornarla directamente
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        
        // Si la ruta ya comienza con 'storage/', usar asset directamente
        if (str_starts_with($this->image_path, 'storage/')) {
            return asset($this->image_path);
        }
        
        // Para rutas relativas, asegurarse de no tener barras iniciales duplicadas
        return asset('storage/' . ltrim($this->image_path, '/'));
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($image) {
            if ($image->is_primary) {
                static::where('product_id', $image->product_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_primary' => false]);
            }
        });
    }
}