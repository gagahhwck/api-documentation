<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'slug',
        'category_product_id',
        'description',
        'price',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_product_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
