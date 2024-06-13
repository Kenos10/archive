<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'ftp_host',
        'ftp_username',
        'ftp_password',
        'ftp_port',
    ];
}
