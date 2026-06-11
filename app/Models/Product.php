<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Burayı ekledik

class Product extends Model
{
    use HasFactory, SoftDeletes; // 2. Buraya SoftDeletes'i geri ekledik

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'image', 
        'category_id', 
        'weight',             // YENİ
        'flavor',             // YENİ
        'nutritional_info'    // YENİ
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Bir ürünün birden fazla yorumu olabilir
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}