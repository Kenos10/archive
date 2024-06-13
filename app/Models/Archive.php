<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip',
        'hospitalRecordId'
    ];

    public function patients(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'hospitalRecordId');
    }
}
