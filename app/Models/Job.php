<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

    public $incrementing = true;

    public $timestamps = false; // Pas de created_at / updated_at en datetime

    protected $fillable = [
        'queue',
        'payload',
        'attempts',
        'reserved_at',
        'available_at',
        'created_at',
    ];

    // Les colonnes reserved_at, available_at, created_at sont stockées en int (timestamps Unix)
    // Tu peux ajouter des accessors pour les convertir en datetime si besoin
}
