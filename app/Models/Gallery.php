<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(GalleryImage::class)->where('is_primary', true);
    }
}
