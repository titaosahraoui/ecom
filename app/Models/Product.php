<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'sales',
        'stock',
        'image',          // main product image
        'thumbnail',      // smaller version of main image
        'images',         // array of additional images
        'image_alt_text', // SEO-friendly alt text
        'status',
        'approval_status', // pending/approved/rejected
        'rejection_reason', // reason if rejected
        'user_id',
    ];

    protected $casts = [
        'price' => 'float',
        'sales' => 'integer',
        'stock' => 'integer',
        'images' => 'array', // automatically serialize/deserialize JSON
    ];

    // Relations
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Approval Status Scopes
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }

    // Image Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : asset('images/default-product.png');
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : $this->image_url;
    }

    public function getImagesUrlsAttribute()
    {
        if (empty($this->images)) {
            return [$this->image_url];
        }

        return array_map(function ($image) {
            return Storage::url($image);
        }, $this->images);
    }

    // Approval Helpers
    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    public function isRejected()
    {
        return $this->approval_status === 'rejected';
    }

    // Status Helpers
    public function markAsApproved()
    {
        $this->update([
            'approval_status' => 'approved',
            'rejection_reason' => null
        ]);
    }

    public function markAsRejected($reason)
    {
        $this->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }

    // Image Helpers
    public function addImage($path)
    {
        $images = $this->images ?? [];
        $images[] = $path;
        $this->images = $images;
        $this->save();
    }

    public function removeImage($path)
    {
        $images = $this->images ?? [];
        $this->images = array_filter($images, function ($image) use ($path) {
            return $image !== $path;
        });
        $this->save();
    }
}
