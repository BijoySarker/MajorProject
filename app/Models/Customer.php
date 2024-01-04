<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_type',
        'registered_by',
        'customer_phone',
        'customer_address',
        'customer_email',
        'customer_postal_code',
        'customer_city',
    ];
}
