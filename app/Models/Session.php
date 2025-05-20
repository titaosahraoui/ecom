<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    // Laravel utilise 'id' comme clé primaire par défaut, ici c'est aussi 'id' donc OK

    protected $table = 'sessions'; // optionnel, car le nom suit la convention

    public $timestamps = false; // La table ne contient pas de colonnes created_at / updated_at

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
