<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalRecordId',
        'caseNo',
        'fileNo',
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth',
        'password',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'hospitalRecordId');
    }

    public function archives(): HasMany
    {
        return $this->hasMany(Archive::class, 'hospitalRecordId');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->caseNo = CaseFormat::getNextCaseNo();
            $patient->fileNo = FileFormat::getNextFileNo();
        });
    }
}
