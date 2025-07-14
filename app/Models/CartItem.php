<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (!$item->price) {
                $item->price = $item->product->current_price;
            }
        });

        static::saved(function ($item) {
            $item->cart->updateTotal();
        });

        static::deleted(function ($item) {
            $item->cart->updateTotal();
        });
    }
}