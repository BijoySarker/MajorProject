<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name', 'price', 'category', 'brand', 'description', 'product_warranty'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault(); // Add ->withDefault() to set default values for the relationship
    }
}
