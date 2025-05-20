<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    public $timestamps = true;

    // Relations

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
