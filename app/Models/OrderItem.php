<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Bu detay bir siparişe aittir
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Bu detay bir ürüne aittir
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}