<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'total'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function updateTotal(): void
    {
        $this->total = $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $this->save();
    }

    public function addItem(Product $product, int $quantity = 1): CartItem
    {
        $existingItem = $this->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            $this->updateTotal();
            return $existingItem;
        }

        $item = $this->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->current_price
        ]);

        $this->updateTotal();
        return $item;
    }

    public function removeItem(int $productId): void
    {
        $this->items()->where('product_id', $productId)->delete();
        $this->updateTotal();
    }

    public function clear(): void
    {
        $this->items()->delete();
        $this->updateTotal();
    }
}