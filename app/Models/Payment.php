<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder',
        'expiry_date',
        'cvv',
    ];

    // Les timestamps sont présents dans la table
    public $timestamps = true;

    // Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
