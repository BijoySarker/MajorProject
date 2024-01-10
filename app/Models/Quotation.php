<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quotation_number',
        'product_id',
        'terms_and_condition',
        'quantity',
        'product_price',
        'quotation_type',
        'company_name',
        'company_address',
        'quotation_subject',
        'created_user',
        'company_persons',
        'attention_quot',
        'dear_sir',
        'quotation_body',
    ];
}
