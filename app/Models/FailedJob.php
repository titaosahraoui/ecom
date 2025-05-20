<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    protected $table = 'failed_jobs';

    protected $fillable = [
        'uuid',
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at',
    ];

    public $timestamps = false;

    // Note : 'failed_at' est un timestamp, tu peux créer un accessor pour le formater si besoin
}
