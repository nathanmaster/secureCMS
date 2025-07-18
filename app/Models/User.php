<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get all ratings by this user
     */
    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    /**
     * Get all comments by this user
     */
    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }

    /**
     * Get all wishlist items by this user
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the count of wishlist items for this user
     */
    public function getWishlistCountAttribute(): int
    {
        return $this->wishlists()->count();
    }

    /**
     * Check if user has a specific product in their wishlist
     */
    public function hasInWishlist(int $productId, string $weight = null): bool
    {
        $query = $this->wishlists()->where('product_id', $productId);
        
        if ($weight) {
            $query->where('selected_weight', $weight);
        }
        
        return $query->exists();
    }
}
