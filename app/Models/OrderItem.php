<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'subtotal',
        'image_path'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (!$item->product_name) {
                $item->product_name = $item->product->name;
            }
            if (!$item->price) {
                $item->price = $item->product->current_price;
            }
            if (!$item->image_path) {
                $primaryImage = $item->product->images->where('is_primary', true)->first() ?? $item->product->images->first();
                if ($primaryImage) {
                    $item->image_path = $primaryImage->image_path;
                }
            }
            $item->subtotal = $item->quantity * $item->price;
        });

        static::saved(function ($item) {
            $item->order->updateTotal();
        });

        static::deleted(function ($item) {
            $item->order->updateTotal();
        });
    }
}