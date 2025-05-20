<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBatch extends Model
{
    protected $table = 'job_batches';

    public $incrementing = false;  // car id est varchar

    protected $keyType = 'string';

    public $timestamps = false;  // pas de created_at / updated_at classiques

    protected $fillable = [
        'id',
        'name',
        'total_jobs',
        'pending_jobs',
        'failed_jobs',
        'failed_job_ids',
        'options',
        'cancelled_at',
        'created_at',
        'finished_at',
    ];

    // Si tu souhaites, tu peux ajouter des accessors/mutators
}
