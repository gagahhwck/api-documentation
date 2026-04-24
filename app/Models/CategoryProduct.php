<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_product_id');
    }
}
