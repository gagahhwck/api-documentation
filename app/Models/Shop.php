<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    protected $fillable = [
        'logo',
        'name',
        'slug',
        'address',
        'phone_number',
        'email',
        'description',
        'status',
    ];

    public function shop_users()
    {
        return $this->hasMany(ShopUsers::class, 'shop_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id');
    }


}
