<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name', 'price', 'category', 'brand', 'description', 'product_warranty', 'product_quantity', 'product_specifications', 'product_image', 'product_gallery'
    ];

    protected $casts = [
        'product_gallery' => 'json',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault(); // Add ->withDefault() to set default values for the relationship
    }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class)
            ->withPivot('quantity', 'unit_price');
    }
}
