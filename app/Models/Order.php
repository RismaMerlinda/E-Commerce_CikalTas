<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'gross_amount',
        'status',
        'payment_type',
        'transaction_id',
        'paid_at',
        'snap_token',
        'midtrans_response',
    ];

    protected $casts = [
        'snap_token' => 'array',
        'midtrans_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
