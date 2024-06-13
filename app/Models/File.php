<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalRecordId',
        'file',
        'fileName',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'hospitalRecordId');
    }

}
