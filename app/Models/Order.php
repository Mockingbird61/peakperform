<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'customer_email', 'address', 'total_price', 'status'];

    // Bir siparişin birden fazla detayı (ürünü) olabilir
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}