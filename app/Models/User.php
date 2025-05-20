<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;  // Add this line

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;  // Add HasRoles here

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',  // You may keep this or remove it since you'll use Spatie roles
        'phone',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // You can keep these constants but they'll be redundant with Spatie roles
    const ROLE_CUSTOMER = 'customer';
    const ROLE_COMMERCIAL = 'commercial';
    const ROLE_ADMIN = 'admin';

    /**
     * Relationships
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(Payment::class);
    }

    public function products() // For commercial users
    {
        return $this->hasMany(Product::class);
    }
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is commercial
     */
    public function isCommercial()
    {
        return $this->role === self::ROLE_COMMERCIAL;
    }

    /**
     * Check if user is client
     */
    public function isClient()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
    public function isCommercialOrAdmin()
    {
        return $this->role === self::ROLE_COMMERCIAL || $this->role === self::ROLE_ADMIN;
    }
}


// class Address extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'user_id',
//         'address_line1',
//         'address_line2',
//         'city',
//         'postal_code',
//         'country',
//         'is_default',
//         'phone'
//     ];

//     protected $casts = [
//         'is_default' => 'boolean'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     // Format address for display
//     public function getFormattedAttribute(): string
//     {
//         return implode(', ', array_filter([
//             $this->address_line1,
//             $this->address_line2,
//             $this->city,
//             $this->postal_code,
//             $this->country
//         ]));
//     }
// }

// class Category extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'name',
//         'slug',
//         'description',
//         'image'
//     ];

//     public function products()
//     {
//         return $this->belongsToMany(Product::class)
//             ->withTimestamps();
//     }

//     // For best sellers per category
//     public function bestSellers()
//     {
//         return $this->products()
//             ->whereHas('orders')
//             ->withCount('orders')
//             ->orderByDesc('orders_count')
//             ->take(5);
//     }
// }

// class Product extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'name',
//         'slug',
//         'description',
//         'price',
//         'sale_price',
//         'stock',
//         'sku',
//         'image',
//         'status',
//         'user_id',
//         'approved_at',
//         'approved_by'
//     ];

//     protected $casts = [
//         'price' => 'decimal:2',
//         'sale_price' => 'decimal:2',
//         'approved_at' => 'datetime'
//     ];

//     // Status constants
//     const STATUS_AVAILABLE = 'available';
//     const STATUS_OUT_OF_STOCK = 'out_of_stock';
//     const STATUS_COMING_SOON = 'coming_soon';

//     public function categories()
//     {
//         return $this->belongsToMany(Category::class)
//             ->withTimestamps();
//     }

//     public function reviews()
//     {
//         return $this->hasMany(Review::class);
//     }

//     public function commercialUser()
//     {
//         return $this->belongsTo(User::class, 'user_id');
//     }

//     public function approvedBy()
//     {
//         return $this->belongsTo(User::class, 'approved_by');
//     }

//     public function orderItems()
//     {
//         return $this->hasMany(OrderItem::class);
//     }

//     // Calculate average rating
//     public function averageRating(): float
//     {
//         return $this->reviews()->avg('rating') ?? 0;
//     }

//     // Check if product is on sale
//     public function isOnSale(): bool
//     {
//         return !is_null($this->sale_price) && $this->sale_price < $this->price;
//     }

//     // Get current price (sale or regular)
//     public function currentPrice(): float
//     {
//         return $this->isOnSale() ? $this->sale_price : $this->price;
//     }
// }

// class Order extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'user_id',
//         'address_id',
//         'total',
//         'status',
//         'tracking_number',
//         'shipping_cost'
//     ];

//     protected $casts = [
//         'total' => 'decimal:2',
//         'shipping_cost' => 'decimal:2'
//     ];

//     // Status constants
//     const STATUS_PENDING = 'pending';
//     const STATUS_PROCESSING = 'processing';
//     const STATUS_SHIPPED = 'shipped';
//     const STATUS_DELIVERED = 'delivered';
//     const STATUS_CANCELLED = 'cancelled';

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function address()
//     {
//         return $this->belongsTo(Address::class);
//     }

//     public function items()
//     {
//         return $this->hasMany(OrderItem::class);
//     }

//     public function payment()
//     {
//         return $this->hasOne(Payment::class);
//     }

//     // Calculate total items count
//     public function totalItems(): int
//     {
//         return $this->items()->sum('quantity');
//     }
// }

// class OrderItem extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'order_id',
//         'product_id',
//         'quantity',
//         'unit_price',
//         'total_price'
//     ];

//     protected $casts = [
//         'unit_price' => 'decimal:2',
//         'total_price' => 'decimal:2'
//     ];

//     public function order()
//     {
//         return $this->belongsTo(Order::class);
//     }

//     public function product()
//     {
//         return $this->belongsTo(Product::class);
//     }
// }

// class PaymentMethod extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'user_id',
//         'card_holder',
//         'card_brand',
//         'card_last_four',
//         'expiry_month',
//         'expiry_year',
//         'is_default'
//     ];

//     protected $hidden = [
//         'deleted_at'
//     ];

//     protected $casts = [
//         'is_default' => 'boolean',
//         'expiry_month' => 'integer',
//         'expiry_year' => 'integer'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     // Masked card number for display
//     public function getMaskedCardAttribute(): string
//     {
//         return "•••• •••• •••• {$this->card_last_four}";
//     }

//     // Formatted expiry date
//     public function getExpiryDateAttribute(): string
//     {
//         return sprintf("%02d/%d", $this->expiry_month, $this->expiry_year);
//     }
// }

// class Review extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'user_id',
//         'product_id',
//         'rating',
//         'comment',
//         'approved'
//     ];

//     protected $casts = [
//         'rating' => 'integer',
//         'approved' => 'boolean'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function product()
//     {
//         return $this->belongsTo(Product::class);
//     }
// }

// class Gallery extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'user_id',
//         'title',
//         'description',
//         'image',
//         'approved',
//         'approved_by',
//         'approved_at'
//     ];

//     protected $casts = [
//         'approved' => 'boolean',
//         'approved_at' => 'datetime'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function approvedBy()
//     {
//         return $this->belongsTo(User::class, 'approved_by');
//     }
// }
