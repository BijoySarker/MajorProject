<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'date',
        'customer_id',
        'product_ids',
        'quantity',
        'paid',
        'due',
        'terms_and_conditions',
        'pay',
        'due'
    ];

    protected $casts = [
        // 'product_ids' => 'array',
        // 'quantity' => 'array',
        'paid' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    } 
    
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
