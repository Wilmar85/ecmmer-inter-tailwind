<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'customer';

    /**
     * Verifica si el usuario es administrador
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'customer_service_email',
        'whatsapp_number',
        'whatsapp_float_button',
        'sales_email',
        'support_email',
        'business_hours',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the wishlist items for the user.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the user's initials.
     *
     * @return string
     */
    public function getInitialsAttribute()
    {
        $name = $this->name;
        $initials = '';
        
        $words = explode(' ', $name);
        
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            
            if (strlen($initials) >= 2) {
                break;
            }
        }
        
        return $initials;
    }

    /**
     * Get the user's role name.
     *
     * @return string
     */
    public function getRoleNameAttribute()
    {
        return $this->role === self::ROLE_ADMIN ? 'Administrador' : 'Cliente';
    }
}
