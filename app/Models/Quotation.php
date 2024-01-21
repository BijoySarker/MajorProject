<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    use HasFactory;
    
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
        'product_id'
    ];
    
    protected $casts = [
        'quantity' => 'array',
        'unit_price' => 'array',
        'product_id' => 'array',
    ];

    
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'unit_price');
    }

    // Accessor to retrieve total price attribute
    public function getTotalPriceAttribute()
    {
        return $this->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->unit_price;
        });
    }

    // Accessor to retrieve an array of product IDs
    public function getProductIdsAttribute()
    {
        return json_decode($this->attributes['product_id'], true);
    }
}
