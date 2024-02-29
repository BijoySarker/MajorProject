<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'system_logo',
        'system_timezone',
        'admin_login_page_background',
        'system_address',
        'system_email',
        'system_phone',
    ];
}
