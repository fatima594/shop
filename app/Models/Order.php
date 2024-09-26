<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'address', 'phone', 'bill', 'shipping_address', 'total', 'shipping_cost', 'card_details'

    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
